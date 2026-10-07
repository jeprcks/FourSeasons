# Shared hosting deployment

The site uses HTML for its rendered pages, with PHP templates in `app/views`. PHP controllers, models, and the router handle requests and data. CSS and browser-side JavaScript stay in `public/assets`.

## Deploy to TMDHosting

1. Select a PHP version supported by the application (PHP 8.1 or newer) and enable the `pdo_mysql` extension.
2. Keep `app`, `config`, `database`, and `storage` outside the web document root. Copy the contents of `public/` into the domain's document root (usually `public_html/`). The document root's `index.php` expects those application folders in its parent directory.
3. Create a MySQL database and user in cPanel, grant the user access to the database, then import `database/schema.sql` followed by `database/seed.sql` using phpMyAdmin.
4. Set `APP_URL` to the site's canonical `https://` URL, `APP_ENV=production`, and `APP_DEBUG=false`. Set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` to the database values provided by the host. On cPanel, these may instead be set in the hosting account's PHP environment configuration.
5. Make `storage/cache`, `storage/logs`, and `storage/uploads` writable by PHP. Keep `storage` outside the document root; the uploads directory has a deny rule as a second safeguard.
6. Enable HTTPS, then test the homepage, a nested page, the inquiry form, and `/admin/login`.

If the host does not allow environment variables, set the corresponding values in `config/app.php` and `config/database.php` before deployment. Do not leave debug enabled or commit production credentials to source control.