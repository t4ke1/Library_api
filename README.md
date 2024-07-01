# Library_api
## Описание
___
    Спецификация
    Сущности:
    • Книга (наименование, год издания, издатель (MtO), автор(MtM))
    • Автор (имя, фамилия, книги (MtM))
    • Издатель (наименование, адрес, книги (OtM))
    Реализовано:
    HTTP API:
    • Получение всех книг (помимо полей книги, возвращать фамилию автора и наименование издательства)
    • Создание нового автора
    • Создание книги с привязкой к существующему автору
    • Редактирование издателя
    • Удаление книги/автора/издателя

    Symfony команды:
    • Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств)
    • Команда по удалению всех авторов, у которых нет книг
___
[api/doc](http://localhost/api/doc)
___
    1.Создать автора /api/add-authors['post'] 
    {
        "firstName":"string",
        "lastName":"string"
    }
    2.Удалить автора /api/delete-author/{id} ['delete'] /api/delete-author/(int)$id
    3.Добавить книгу /api/add-book ['post']
    {
        "title":int,
        "publishDate":"yyyy.mm.dd",
        "authorId":[int,int],
        "publisherId":int
    }  
    4.Удалить книгу /api/delete-book/{id} ['delete'] /api/delete-book/(int)$id
    5.Получить список всех книг, фамилию автора и наименование издательства['get'] /api/get-all-books
    6.Добавить издателя /api/add-publisher ['post'] /api/add-publisher
    {
        "name":"string",
        "address":"string"
    }
    7.Удалить издатея /api/delete-publisher/{id} ['delete'] /api/delete-publisher/(int)$id
    8.Обновить издателя /update-publisher ['put']
    {
        "id":int,
        "name":"string",
        "address":"string"
    }
___
## Установка
___
### Docker
    Перед тем как начать, убедитесь, что у вас установлен Docker. Вы можете скачать 
    Docker с официального сайта 
[Docker](https://www.docker.com/get-started)


### Проверка установки Docker
___
    Для проверки, установлен ли Docker, выполните следующую команду в терминале:
```bash
    docker --version
```
    Если Docker установлен правильно, вы увидите сообщение с версией Docker, например:
    Docker version 20.10.7, build f0df350
___
### Запуск
___
    1. Клонируйте репозиторий 
    2. Соберите контейнеры Docker
```bash
    docker compose up --build
```
    3.Проверьте статус контейнеров

```bash
    docker ps
``` 
    Eсли контейнеры запущены правильно, вы увидите сообщение с информацией о контейнерах, например:
    mfo-php-1           mfo-php       "docker-php-entrypoi…"   php           13 hours ago   Up 13 hours   0.0.0.0:8000->8000/tcp, 9000/tcp
    mfo-postgres_db-1   postgres:16   "docker-entrypoint.s…"   postgres_db   13 hours ago   Up 13 hours   0.0.0.0:5432->5432/tcp

    4. Установите и обновите все зависимости composer (В контейнере PHP)
```bash
    docker compose exec php bash -c "composer update"
    
```
    5. Выполните миграцию
```bash
    docker compose exec php bash -c "php bin/console doctrine:migrations:migrate --no-interaction"
```
    • Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств)
```bash
    docker compose exec php bash -c "php bin/console doctrine:fixtures:load --no-interaction"
    
```
        • Команда по удалению всех авторов, у которых нет книг
```bash
     docker compose exec php bash -c "php bin/console DeleteAuthor --no-interaction"
    
```
