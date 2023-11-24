**С чего начать:**
1. Запустить composer install (установить все зависимости если потребует)

2. Настроить подключение к БД 
   - host: 127.0.0.1
   - user: 
3. Выполнить миграции: php artisan migrate

4. засеять БД полностью: php artisan db:seed

5. засеять БД данными по отдельности можно следующими командами:
   для заполнения категорий:
     php artisan db:seed --class=CategoriesTableSeeder
   для заполнения продуктами:
     php artisan db:seed --class=ProductsTableSeeder
   для заполнения изображениями:
     php artisan db:seed --class=ImagesTableSeeder
   для заполнения новостями:
     php artisan db:seed --class=ArticlesTableSeeder
   для заполнения изображениями новостей:
     php artisan db:seed --class=ArticlesImagesTableSeeder


**Полезные команды:**

1. Запустить локальный сервер:
    php artisan serve

2. Создать суперпользователя для админки orchid: 
    php artisan orchid:admin <логин> <почта> <пароль>
    вход в админку пример: localhost:8000/admin/products


Дополнительные стили можно задавать здесь: public/css/custom.css


**Нужно реализовать/сделать:**


1. Добавить сортировку на новости
2. Добавить сортировку/фильтрацию на продукты
3. Выделить пагинацию отдельно например в resources/views/frontend/components/pagination.blade.php
4. Подписка на...
5. Форма обратной связи
6. Добавить "Поделиться" через соц. сети
7. Оценки и Отзывы
8. (Количество посещений)
9. Предусмотреть загрузку цен через xml или другой док. предприятия
10. Проверить возможность загрузки новостей из ВК (после выноса во внешку)
