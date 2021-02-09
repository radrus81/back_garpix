## Установка

1. склонировать репозиторий git clone https://github.com/radrus81/back_garpix.git

2. Перейти в папку с исходниками back_garpix

3. Выполнить команду composer update

4. Создать файл .env из .env.example

5. Сгенерировать ключ командой php artisan key:generate

6. Создать базу данный для проекта и прописать данные в .env

7. Мигрировать базу данных командой php artisan migrate

8. Заполнить таблицы данными командой php artisan db:seed

9. Запустить сервер командой php artisan serve

10. Открыть приложение в баузере на localhost:8000

Для разработки установить пакеты командой

npm install

сборка командой npm run dev

запуск в режиме слежки за кодом npm run watch
