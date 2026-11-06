# Local project QA — 6 November 2026

Target: `http://127.0.0.1:8000`. Results apply to the current local database and code, not a deployed environment.

## Coverage

- 67 distinct requested URLs: 17 public/utility URLs and 50 admin URLs, including existing record edit pages, prospect prefilled onboarding forms, and stage filters.
- 77 HTTP checks total, including public navigation repeated under an admin session. Every page check reached HTTP 200 after expected redirects.
- Seven local assets returned HTTP 200: built CSS/JavaScript, Vite development assets, favicon, and social image.
- Unknown pages returned 404, missing CSRF tokens returned 419, guests were redirected to login, and logout revoked access.
- Browser rendering checks covered public page templates, all admin page templates, existing homepage/user edit screens, and desktop/mobile layouts. No server-error pages or console errors were found in those checks.
- Mobile checks used a 390px viewport. Homepage and service-page horizontal overflow was reproduced and repaired; checked admin layouts also fit the viewport. Monthly-plan fields displayed and purchase-price fields hid when switching plans.
- Database-backed blog detail, drafts, customer/photo screens, mutations, and empty states were also tested using isolated fixtures where corresponding live records were absent. A missing/draft record is expected to return 404, not 200.

## Repairs

- Separate rate-limit counters for admin login, demo requests, and newsletter subscriptions. Previously, submissions to one endpoint could exhaust the others' limit.
- Validate payment amounts before writing payments; save payment and billing updates together in a transaction.
- Prevent January 31 monthly billing from overflowing into March when extending by one month.
- Retain monthly-plan selection after customer form validation errors.
- Validate prospect references and customer website length/scheme before saving.
- Return a useful validation error for unreadable Excel files rather than a server error or importing the corrupt file as CSV.
- Constrain the shared demo form grid and fields so long service names do not widen mobile pages.
- Hide inactive carousel buttons when no articles are published.
- Remove duplicate `APP_URL` in the environment template and align the robots sitemap test with the configured public `bikrify.xyz` domain.

## Repeating the checks

```powershell
php artisan test --compact
npm run build
composer validate --no-check-publish --no-interaction
New-Item -ItemType Directory -Path artifacts/qa -Force
php scripts/qa-pages.php | Set-Content -Encoding utf8 artifacts/qa/pages.json
# Set QA_EMAIL and QA_PASSWORD in this process to an existing local admin's credentials.
node scripts/qa-http.mjs
```

The HTTP script uses GET requests plus login/logout. It does not create, edit, or delete business records. It writes the exact checked URL/status list to `artifacts/qa/http-results.md` and JSON to `artifacts/qa/http-results.json`. These generated reports are ignored by Git and contain no credentials.

Form mutation tests use an in-memory SQLite database, fake queue/storage where appropriate, and no real messages, customer changes, or payment transactions. Actual external email delivery, external websites/WhatsApp, and production hosting were outside this local QA run.
