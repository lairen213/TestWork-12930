# TestWork-12930
<h1>TestWork-12930 - как запустить?</h1>

<p>Переходим в папку front-end и запускаем команду npm ci для того чтобы установились все нужные пакеты</p>

<p>В папке front-end, в файле .env меняем VITE_URL на тот url который будетт ссылатся на бек</p>

<p>После, на беке нужно создать .env файл, запустить миграции и так же можно запустить сидер для заполнения постов - php artisan db:seed --class=PostSeeder</p>
