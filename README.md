# Bikrify.io

Bikrify.io is a Laravel application for presenting Bikrify's business software services and managing demo requests and customer relationships. The public site includes service pages and contact/subscription forms; the password-protected admin area supports lead follow-up, prospect imports, and customer/payment records.

## Features

- Public home page and database-driven service pages.
- Demo request form with validation and rate limiting. Requests are queued for email notifications.
- Newsletter subscription form.
- HTTP Basic Authentication-protected admin pages for leads, prospects, and customers.
- Prospect import from CSV, XLS, and XLSX files.
- Customer and payment tracking, including license status lookup.
- Sitemap, policies, security, case studies, and service status pages.

## Requirements

- PHP 8.2 or newer
- Composer
- Node.js and npm
- PHP extensions required by Laravel 12 and PhpSpreadsheet

## Local setup

Run the following from the project root:

```sh
composer install
npm install
cp .env.example .env
php artisan key:generate
```

The default database connection is SQLite. Create the database file if it does not exist, then apply migrations and seed the initial service content and admin user:

```sh
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
```

Before seeding, set the admin email and password in `.env` if you do not want the defaults:

```dotenv
BIKRIFY_ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=replace-with-a-strong-password
```

The admin account is created only if it does not already exist. If `ADMIN_PASSWORD` is unset on first seeding, Laravel generates a random password and prints the credentials to the command output. Save that password securely. Seeding again will not change an existing admin password.

Build the front-end assets and start the application:

```sh
npm run build
php artisan serve --host=127.0.0.1 --port=8001
```

Visit [http://127.0.0.1:8001](http://127.0.0.1:8001). To work on the front end with Vite hot reload, run `npm run dev` in a separate terminal instead of using the production asset build.

Demo requests are processed by Laravel's queue. For local development, start a worker in another terminal:

```sh
php artisan queue:listen --tries=1
```

The example environment uses the `log` mailer, which writes outgoing mail to the application log rather than delivering it. Configure a real mail transport in `.env` to send email.

## Configuration

Application-specific settings are read from `.env`:

| Variable | Purpose | Default |
| --- | --- | --- |
| `BIKRIFY_ADMIN_EMAIL` | Admin account email and recipient for demo notifications | `admin@example.com` |
| `ADMIN_PASSWORD` | Password for the admin account when it is first seeded | Randomly generated if unset |
| `BIKRIFY_EMAIL` | Public contact email | `hello@example.com` |
| `BIKRIFY_PHONE` | Public contact phone number | `+880 1768-002727` |
| `BIKRIFY_WHATSAPP` | WhatsApp number | `8801768002727` |
| `BIKRIFY_ADDRESS` | Public business address | `Dhaka, Bangladesh` |

Laravel's standard environment variables also control the database, mail, queue, cache, session, and application URL. Do not commit `.env` or production credentials.

## Routes

| Path | Description |
| --- | --- |
| `/` | Public home page |
| `/services/{service}` | Service details, addressed by service slug |
| `/demo` | Submit a demo request |
| `/subscribe` | Subscribe an email address |
| `/sitemap.xml` | XML sitemap |
| `/policies` | Policies |
| `/security` | Security information |
| `/case-studies` | Case studies |
| `/status` | Application and database status |
| `/admin/leads` | View and update demo leads (HTTP Basic Authentication) |
| `/admin/prospects` | Review and import prospects (HTTP Basic Authentication) |
| `/admin/customers` | View and manage customers and payments (HTTP Basic Authentication) |
| `/api/license/{key}` | Return the status associated with a license key |

The admin routes use Laravel HTTP Basic Authentication. Use the seeded admin email and password when prompted by the browser.

## Development and tests

Run the automated test suite with:

```sh
php artisan test
```

Useful commands:

```sh
php artisan route:list
php artisan migrate:status
npm run dev
npm run build
```

## Deployment notes

- Set `APP_ENV=production`, `APP_DEBUG=false`, a secure `APP_KEY`, and production-specific database and mail settings.
- Use a real mail transport and run a persistent queue worker so demo request emails are delivered.
- Build front-end assets with `npm run build`.
- Run database migrations during deployment with `php artisan migrate --force`.
- Set a strong `ADMIN_PASSWORD` before creating the first admin user. Do not use the example credentials in a public deployment.

## License

No project-specific license is currently declared. Contact the project owner before redistributing this application.
