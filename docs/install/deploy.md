# Деплой

## Деплой

    git checkout develop
    git pull
    composer update
    php vendor/php7lab/eloquent/bin/console db:migrate:up
    php vendor/phpunit/phpunit/phpunit

Распределение веток:

* `develop` - используется только на тестовом
* `master` - используется только на боевом

## Конфигурация

Вся необходимая конфигурация размещается в файле `.env` и `.env.local`.

## Развертка приложения для автотестов

### Развертка/переразвертка БД

    cd vendor/php7lab/eloquent/bin
    php console db:delete-all-tables --withConfirm=0
    php console db:migrate:up --withConfirm=0
    php console db:fixture:import --withConfirm=0

### Запуск автотестов

    php vendor/phpunit/phpunit/phpunit
