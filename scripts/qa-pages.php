<?php

// Read-only inventory of pages backed by records in the current database.
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$pages = [
    'public' => ['/', '/e-commerce-software-company-bangladesh', '/blog', '/case-studies', '/security', '/status', '/policies', '/sitemap.xml', '/robots.txt', '/up', '/admin/login', '/services/online-store-order-system', '/services/pos-inventory-system', '/services/custom-erp-automation'],
    'admin' => ['/admin', '/admin/leads', '/admin/prospects', '/admin/prospects?stage=no_response', '/admin/prospects?stage=interested', '/admin/prospects?stage=hot', '/admin/customers', '/admin/customers/new', '/admin/blog/posts', '/admin/blog/posts/create', '/admin/homepage/what-we-build', '/admin/homepage/what-we-build/create', '/admin/users', '/admin/users/create'],
];
foreach (App\Models\Service::pluck('slug') as $slug) $pages['public'][] = '/services/'.$slug;
foreach (App\Models\Post::published()->pluck('slug') as $slug) $pages['public'][] = '/blog/'.$slug;
foreach (App\Models\Post::pluck('id') as $id) $pages['admin'][] = '/admin/blog/posts/'.$id.'/edit';
foreach (App\Models\HomeBuildItem::pluck('id') as $id) $pages['admin'][] = '/admin/homepage/what-we-build/'.$id.'/edit';
foreach (App\Models\User::pluck('id') as $id) $pages['admin'][] = '/admin/users/'.$id.'/edit';
foreach (App\Models\Prospect::pluck('id') as $id) $pages['admin'][] = '/admin/customers/new?prospect='.$id;
foreach (App\Models\Customer::whereNotNull('photo')->get() as $customer) $pages['admin'][] = '/admin/customers/'.$customer->id.'/photo';
echo json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
