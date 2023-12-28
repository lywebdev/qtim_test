### Установка и запуск проекта

- git clone git@github.com:lywebdev/qtim_test.git
- docker-compose up -d --build
- внутри запущенного web контейнера выполнить composer install

#### Для получения результата тестового задания перейти по адресу:
localhost:8080/api/test/event

В файле var/log/dev.log появятся данные о тестовом событии. Данные в файл запишутся из класса события, слушателя посредством созданного класса-декоратора LoggingEventDispatcher

#### Анализ кода
Выполните команду php vendor/bin/psalm для отображения результата анализа