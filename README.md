### Приложение "Опросы"

Создание опросников с вариантами ответов, отображение созданных
опросников, фильтрация из списка опросов по наименованию,
сохранение результатов голосования.

---

Демонстрация работы Laravel и пакета Livewire. 

Приложение демонстрирует возможности валидации форм, рендеринг 
шаблонов Livewire и взаимодействие элементов шаблона с backend (*actions*),
тестирование Livewire компонентов.

---
Стек:
- 🐘 Php 8.2 + Laravel 10 + Livewire 2.
- 🦖 MariaDb
- 🐳 Docker (Docker compose) + Laravel Sail
- ⛑ Тестирование компонентов Livewire.

#### Настройка проекта и подготовка к старту docker

Настроить переменные окружения (если требуется изменить их):

```shell
cp .env.example .env
```

⚠ Если на машине разработчика установлен **php** и **composer** то можно выполнить команду:

```shell
composer install --ignore-platform-reqs
```

⚠ Если не установлен **php** и **composer** на машине разработчика то установить зависимости проекта можно так:

```shell
docker run --rm -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

на этом подготовка к работе с Laravel Sail закончена.

#### Запуск проекта

Поднять docker контейнеры с помощью Laravel Sail
```shell
./vendor/bin/sail up -d
```

1.  Сгенерировать application key

```shell
./vendor/bin/sail artisan key:generate
```

2. Выполнить миграции и заполнить таблицы тестовыми данными

```shell
./vendor/bin/sail artisan migrate --seed
```
3. Установить зависимости для фронта

```shell
./vendor/bin/sail npm install
```

4. Собрать фронт

```shell
./vendor/bin/sail npm run build
```

Приложение доступно по адресу http://localhost

