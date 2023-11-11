**С чего начать:**
1. Запустить composer install (установить все зависимости если потребует)

2. Настроить подключение к БД 
   - host: 127.0.0.1
   - user: 
3. Выполнить миграции: php artisan migrate

4. засеять БД полностью:
     php artisan db:seed
5. засеять БД данными по отдельности можно следующими командами:
   для заполнения категорий:
     php artisan db:seed --class=CategoriesTableSeeder
   для заполнения продуктами:
     php artisan db:seed --class=ProductsTableSeeder
   для заполнения изображениями:
     php artisan db:seed --class=ImagesTableSeeder


**Полезные команды:**

1. Запустить локальный сервер:
    php artisan serve

2. Создать суперпользователя для админки orchid: 
    php artisan orchid:admin <логин> <почта> <пароль>
    вход в админку пример: localhost:8000/admin/products


Дополнительные стили можно задавать здесь: public/css/custom.css


**Нужно реализовать/сделать:**

1. 
