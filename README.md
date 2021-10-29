# Symfony Admin Project
_Symfony version 4.4_

#### Setup instructions:
To fetch all composer dependencies
```shell script
composer install
```
To get necessary node dependencies
```shell script
yarn install --frozen-lockfile
```
To compile assets
```shell script
yarn dev
```
To watch and compile assets when js or css files change
```shell script
yarn watch
```
To get database connection in place
```text
1. Create your .env.local file (see .env file for example)
2. Create your mysql database
3. Update DATABASE_URL variable to reflect your specific configurations (dbname, user, password, mysql port)
4. Populate your database by running migrations - ./bin/console doctrine:migrations:migrate
```

### Static Analysis ###
To run PHPStan execute command:
```shell script
vendor/bin/phpstan analyse src tests --level max
OR
composer phpstan
```

### Run on Docker ###
To launch project on docker, run
```shell script
cd ./docker && docker-compose up
```

You can now access project in browser using: http://localhost:80

To run Symfony commands execute frock `docker` directory:
```shell script
docker-compose exec php-fpm php bin/console <command>
```

Run tests with:
```shell script
docker-compose exec php-fpm php bin/phpunit
```

### Issues ###

1. /admin/login is not working ("Too many redirects")
2. 500 error when creating user with the same username.
3. Deleted user should not be able to login.
4. User should not be able to delete himself.
5. User passwords shouldn't be stored in plaintext.
6. User can't be deleted by superadmin
7. `/superadmin` routes should be accessible only to the super admin, now admin is able to access `/superadmin/home`
8. /admin/login is not working ("Too many redirects")
9. After login ROLE_ADMIN must be redirect to User list, while ROLE_SUPER_ADMIN to `/superadmin/home`
