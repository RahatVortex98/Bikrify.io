import fs from 'node:fs';

const base = process.env.QA_BASE_URL || 'http://127.0.0.1:8000';
const pages = JSON.parse(fs.readFileSync('artifacts/qa/pages.json', 'utf8').replace(/^\uFEFF/, ''));
const cookies = new Map();
const report = { checkedAt: new Date().toISOString(), pages: [], assets: [], checks: [], errors: [] };
async function request(path, options = {}, follow = true) {
  let url = new URL(path, base);
  for (let redirects = 0; redirects < 10; redirects++) {
    const res = await fetch(url, { ...options, redirect: 'manual', signal: AbortSignal.timeout(20000), headers: { ...options.headers, Cookie: url.origin === new URL(base).origin ? [...cookies].map(([k,v]) => `${k}=${v}`).join('; ') : '', Accept: 'text/html,application/xhtml+xml' } });
    for (const value of res.headers.getSetCookie()) {
      const pair = value.split(';')[0], i = pair.indexOf('=');
      cookies.set(pair.slice(0,i), pair.slice(i+1));
    }
    if (follow && [301,302,303,307,308].includes(res.status)) {
      url = new URL(res.headers.get('location'), url);
      if (url.origin !== new URL(base).origin) throw new Error('Unexpected external redirect');
      options = {};
      continue;
    }
    return { status: res.status, url: url.href, location: res.headers.get('location'), type: res.headers.get('content-type') || '', body: await res.text() };
  }
  throw new Error('Redirect loop');
}
const assets = new Set(['/favicon.ico', '/og-image.jpg']);
if (fs.existsSync('public/build/manifest.json')) {
  for (const entry of Object.values(JSON.parse(fs.readFileSync('public/build/manifest.json','utf8')))) {
    if (entry.file) assets.add('/build/'+entry.file);
    for (const css of entry.css || []) assets.add('/build/'+css);
  }
}
async function crawl(initial, kind) {
  const queue = [...initial], visited = new Set();
  while (queue.length) {
    const path = queue.shift();
    if (visited.has(path)) continue;
    if (visited.size >= 300) throw new Error('Crawl limit reached; inventory incomplete');
    visited.add(path);
    try {
      const res = await request(path);
      const title = res.body.match(/<title>([\s\S]*?)<\/title>/i)?.[1] || '';
      report.pages.push({ kind, path, status: res.status, finalUrl: res.url, title });
      if (res.status !== 200) report.errors.push(`${kind} ${path}: HTTP ${res.status}`);
      if (kind === 'admin' && new URL(res.url).pathname === '/admin/login') report.errors.push(`Admin redirected to login: ${path}`);
      if (!res.type.includes('text/html') || res.status !== 200) continue;
      for (const match of res.body.matchAll(/\b(href|src)=["']([^"']+)["']/gi)) {
        const value = match[2].replaceAll('&amp;', '&');
        if (/^(#|mailto:|tel:|data:|javascript:)/i.test(value)) continue;
        const url = new URL(value, res.url); url.hash = '';
        if (url.origin !== new URL(base).origin) {
          if (['localhost', '127.0.0.1', '[::1]'].includes(url.hostname)) assets.add(url.href);
          continue;
        }
        const target = url.pathname + url.search;
        if (match[1].toLowerCase() === 'src' || /\.(css|js|png|jpg|jpeg|svg|ico|webp|woff2?)(\?|$)/i.test(target)) assets.add(target);
        else if (kind === 'admin' || !url.pathname.startsWith('/admin')) queue.push(target);
      }
    } catch (e) { report.errors.push(`${path}: ${e.message}`); }
  }
}
try {
  const missing = await request('/qa-page-that-does-not-exist');
  report.checks.push({ check: 'Unknown page returns 404', passed: missing.status === 404 });
  const csrf = await request('/admin/login', {method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'email=qa%40example.test&password=not-a-real-password'}, false);
  report.checks.push({check:'Missing CSRF token rejected',passed:csrf.status===419});
  const guard = await request('/admin/users', {}, false);
  report.checks.push({ check: 'Guest redirected to login', passed: guard.status === 302 && guard.location?.endsWith('/admin/login') });
  await crawl(pages.public, 'public');
  if (!process.env.QA_EMAIL || !process.env.QA_PASSWORD) throw new Error('Set QA_EMAIL and QA_PASSWORD to check authenticated pages');
  const login = await request('/admin/login');
  const token = login.body.match(/name="_token"\s+value="([^"]+)"/)?.[1];
  if (!token) throw new Error('Login CSRF token missing');
  const auth = await request('/admin/login', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: new URLSearchParams({ _token: token, email: process.env.QA_EMAIL, password: process.env.QA_PASSWORD }) }, false);
  if (auth.status !== 302 || auth.location?.endsWith('/admin/login')) throw new Error('Admin sign-in failed');
  await crawl(pages.admin, 'admin');
  for (const asset of assets) {
    const res = await request(asset);
    report.assets.push({ path: asset, status: res.status });
    if (res.status !== 200) report.errors.push(`Asset ${asset}: HTTP ${res.status}`);
  }
  const panel = await request('/admin/users');
  const logoutToken = panel.body.match(/name="_token"\s+value="([^"]+)"/)?.[1];
  if (logoutToken) await request('/admin/logout', { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:new URLSearchParams({_token:logoutToken}) }, false);
  const loggedOut = await request('/admin/users', {}, false);
  report.checks.push({ check:'Logout revokes access', passed:loggedOut.status === 302 && loggedOut.location?.endsWith('/admin/login') });
} catch (e) { report.errors.push(e.message); }
for (const check of report.checks) if (!check.passed) report.errors.push(check.check);
fs.writeFileSync('artifacts/qa/http-results.json', JSON.stringify(report, null, 2));
fs.writeFileSync('artifacts/qa/http-results.md', '# Local HTTP QA results\n\nChecked: '+report.checkedAt+'\n\n| Access | Requested path | Final status |\n| --- | --- | --- |\n'+report.pages.map(p=>`| ${p.kind} | ${p.path} | ${p.status} |`).join('\n')+'\n\n## Assets\n\n'+report.assets.map(a=>`- ${a.status} ${a.path}`).join('\n')+'\n\n## Authentication and error handling\n\n'+report.checks.map(c=>`- ${c.passed?'PASS':'FAIL'} ${c.check}`).join('\n')+'\n\nErrors: '+(report.errors.join('; ')||'None')+'\n');
console.log(JSON.stringify({ pages: report.pages.length, assets: report.assets.length, checks: report.checks, errors: report.errors }, null, 2));
process.exitCode = report.errors.length ? 1 : 0;
