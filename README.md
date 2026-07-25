# URL Shortner
# This is Laravel 12 and PHP Requirement is
PHP 8 and above

# Installation
**Clone the project and run this command**
```
git clone https://github.com/arun26282/url-shortner
cd url-shortner

composer install
npm install
npm run build

cp .env.example .env
php artisan key:generate
php artisan migrate
```

**To get Super Admin Account run**
```
php artisan db:seed
```

**------CREDENTIALS FOR SUPER ADMIN-------------------**
Username : superadmin@superadmin.com
Password : password

**------DEFAULT PASSWORD FOR ALL USER INVITED---------**
Password : password

**To Run the server run**
```
php artisan serve
```

**To run tests**
```
php artisan test --filter UrlShortnerTest
```
