# Admin routes

Base URL for local development: http://127.0.0.1:8000

Sign in at `/admin/login` using an existing admin email and password. All other admin routes require an authenticated admin session. Forms include CSRF protection. Sign out uses POST rather than a navigation link.

| Method | Path | Purpose |
| --- | --- | --- |
| GET | /admin/login | Sign-in page |
| POST | /admin/login | Sign in (rate limited) |
| ANY | /admin | Redirect to leads |
| POST | /admin/logout | Sign out |
| GET | /admin/users | List users and admins |
| GET | /admin/users/create | Add-admin form |
| POST | /admin/users | Create admin |
| GET | /admin/users/{user}/edit | Edit user and change password |
| PUT/PATCH | /admin/users/{user} | Save user/password changes |
| GET | /admin/leads | Website demo requests |
| PATCH | /admin/leads/{lead} | Mark lead contacted |
| GET | /admin/prospects | Customer hunting |
| POST | /admin/prospects/import | Import prospects |
| PATCH | /admin/prospects/{prospect} | Update prospect stage |
| GET | /admin/customers | Customers and billing |
| GET | /admin/customers/new | New-customer form |
| POST | /admin/customers | Create customer |
| POST | /admin/customers/{customer}/pay | Record payment |
| PATCH | /admin/customers/{customer}/toggle | Toggle customer status |
| GET | /admin/customers/{customer}/photo | Customer photo |
| GET | /admin/blog/posts | List blog posts |
| GET | /admin/blog/posts/create | Create-post form |
| POST | /admin/blog/posts | Create post |
| GET | /admin/blog/posts/{post}/edit | Edit-post form |
| PUT | /admin/blog/posts/{post} | Update post |
| GET | /admin/homepage/what-we-build | Homepage cards |
| GET | /admin/homepage/what-we-build/create | Create-card form |
| POST | /admin/homepage/what-we-build | Create card |
| GET | /admin/homepage/what-we-build/{homeBuildItem}/edit | Edit-card form |
| PUT | /admin/homepage/what-we-build/{homeBuildItem} | Update card |
| DELETE | /admin/homepage/what-we-build/{homeBuildItem} | Delete card |

All admins can add admins and edit user details/passwords. New passwords require confirmation and at least 12 characters. Leave the password blank when editing to keep it unchanged. Passwords are hashed and never displayed. Password changes invalidate the changed user's other authenticated admin sessions on their next request.

For another environment, run `php artisan migrate` and `npm run build` before using the new login and user panel.
