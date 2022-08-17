# Expense Management API

## Usage

1. Clone project.
2. Create .env file, copy content from .env.example to .env file and config in .env:

- Config Database
```
DB_CONNECTION=mongo
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=database_name
DB_USERNAME=user_name
DB_PASSWORD=password
```

- Config Email
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=email_address
MAIL_PASSWORD=email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME=null
```

- Config Google Drive
```
FILESYSTEM_CLOUD=google
GOOGLE_DRIVE_CLIENT_ID=xxx.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=xxx
GOOGLE_DRIVE_REFRESH_TOKEN=xxx
GOOGLE_DRIVE_FOLDER_ID=xxx
```

3. Run
```
$ composer install
$ php artisan key:generate
$ php artisan jwt:secret
$ php artisan db:seed --class=DatabaseSeeder
$ php artisan storage:link
$ php artisan route:clear
$ php artisan config:clear
```

4. Local development server
- Run
```
$ php artisan serve
```
5. Login with default admin acount:
```
email: admin@gmail.com
password: admin432000
```
