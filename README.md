Сделано по ТЗ https://docs.google.com/document/d/1I5lGAuGzM_TahaYenMmEimxvlkV30EwcEryoHSgMOJw/edit?usp=sharing

## Установка

`git clone https://github.com/danyaagay/738848`

Установка всех необходимых зависимостей:

```
composer update
composer install
```

Коллекция Postman находится в файле 738848.postman_collection.json

### Docker (рекомендуется)

Перейдите в папку приложение и используйте комманду

`./vendor/bin/sail up`

Будет создан Docker контейнер который можно запустить через Docker.

Все запросы будут по адресу localhost/api/

Не забудьте выполнить миграции 

`php artisan migrate`

### Обычная

Запуск на стандартном порте (8000):

`php artisan serve`

Если стандартный порт занят и вы хотите запустить на другом, укажите аргумент --port:

`php artisan serve --port=8088`

Все запросы будут по адресу localhost:8000/api/ или localhost:8088/api/

Не забудьте выполнить миграции 

`php artisan migrate`

### Стек технологий

Основной язык бэкенда: PHP 8.1.5

Laravel Framework 9.14.1 в качестве фреймворка.

MySQL 8.0.29 в качестве базы данных

Composer в качестве менеджера пакетов.

## Документация

Существуют продукты и магазины, цена и количество одного продукта может отличаться в разных магазинах.

### Авторизация

Некоторые запросы такие как user@index, user@destroy созданы для удобства проверки:

GET /api/user
Получить всех пользователей

POST /api/user?login={login}&password={password}
Создать пользователя

DELETE /api/user/{user}
Удалить пользователя

После создания пользователя нам потребуется токен для доступа к остальным методам, для его получения:

POST /api/token?login={login}&password={password}
Получить или обновить токен

### Методы

Для этих методов требуется токен, его передаем в параметре api_token.
Например /api/product?api_token={token}

Продукты:

GET /api/product
Получить все продукты

GET /api/product/{product}
Получить один продукт

GET /api/product/search?name={name}&sort={sort}&{column}={value}
Сортировать, искать продукты в магазинах (подробнее о нем далее)

POST /api/product?name={name}
Создать продукт

PUT /api/product/{product}?name={name}
Обновить продукт

DELETE /api/product/{product}
Удалить продукт

POST /api/product/{product}/shop/{shop}?amount={amount}&price={price}
Создать связь, где amount это количество продукта а price его цена в конкретном магазине

DELETE /api/product/{product}/shop/{shop}
Удалить связь

Магазины:

GET /api/shop
Получить все магазины

POST /api/shop?name={name}
Создать магазин

DELETE /api/shop?name={name}
Удалить магазин

### Сортировка и поиск

GET /api/product/search
Позволяет искать и сортировать продукты, вы можете указать несколько name и sort:

GET /api/product/search?name=milk,bread&sort=price:asc,amount:desc
Найти хлеб и молоко, отсортировать их по возрастанию цены и уменьшению количества.

Также можно указать несколько столбцов для поиска:

GET /api/product/search?name=bread&price=2.99&amount=5
Найти хлеб имеющий цену 2.99 и количество 5

## Несколько слов от автора

DELETE /api/user/{user} не защищен, он существует только для удобства работы с базой при тестировании, в готовом приложении мы должны проверить что человек удаляющий себя или другого действительно имеет на это права.

GET /api/product/search я мог вынести это в GET /api/product но оставил его для целей тестирования.

В контроллере user и shop не реализован паттерн репозитория, посколько в них всего один метод возврата.

Методы создания, обновления и удаления не захватывают репозиторий, я прочитал о нем больше и пришел к выводу что репозиторий должен только возвращать информацию.
