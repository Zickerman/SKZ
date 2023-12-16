**С чего начать:**
1 Запустить composer install (установить все зависимости если потребует)

2 Настроить подключение к БД 
   - host: 127.0.0.1
   - user: 
3 Выполнить миграции: php artisan migrate

4.1 засеять БД полностью: php artisan db:seed

4.2 или засеять БД данными по отдельности можно следующими командами:
        категорий: php artisan db:seed --class=CategoriesTableSeeder
        продуктами: php artisan db:seed --class=ProductsTableSeeder
        изображениями: php artisan db:seed --class=ImagesTableSeeder
        новостями: php artisan db:seed --class=ArticlesTableSeeder
        изображениями новостей: php artisan db:seed --class=ArticlesImagesTableSeeder


**Полезные команды:**

1. Запустить локальный сервер:
    php artisan serve

2. Установить(если нет) админку orchid https://orchid.software/ru/docs/installation/

3. Создать суперпользователя для админки orchid: 
    php artisan orchid:admin <логин> <почта> <пароль>
    вход в админку пример: localhost:8000/admin/products

4. полезные команды (в package.json) для генерации JS (Laravel Mix):
   npm run watch следит за всеми файлами в webpack.mix.js и при изменении, компилирует автоматически;
   npm run prod перекомпилирует отслеживаемые файлы (для продакшена).


Дополнительные стили можно задавать здесь: public/css/custom.css


**Нужно реализовать/сделать:**


1. Поиск по ...
2. Подписка на...
3. Форма обратной связи
4. Добавить "Поделиться" через соц. сети
5. Оценки и Отзывы
6. (Количество посещений)
7. Предусмотреть загрузку цен через xml или другой док. предприятия
8. Проверить возможность загрузки новостей из ВК (после выноса во внешку)
