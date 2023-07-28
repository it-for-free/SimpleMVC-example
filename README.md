# SimpleMVC-example

Пример проекта, разработанного на учебном движке (MCV-фреймворке) [SimpleMVC](https://github.com/it-for-free/SimpleMVC).


## Установка

ВНИМАНИЕ: о composer-е и остальных моментах см. [в уроках по SimpleMVC](http://fkn.ktu10.com/?q=node/9429).

1. Делаем форк репозитория https://github.com/it-for-free/SimpleMVC-example  и клонируем его из своего гитхаб-профиля на компьютер.
2. Создаём у себя на машине _виртуальный хост_ с корнем в директории `web/` этого проекта проекта ([например так](http://fkn.ktu10.com/?q=node/8593)).
3. Подтягиваем зависимости композером:
``` 
composer install
```
4. Разворачиваем приложенный _дамп_ из файла `basedump.sql` ([например так](http://fkn.ktu10.com/?q=node/1173)).
5. Создаём копию `application/config/web-local-example.php` в той же папке с названием `application/config/web-local.php` 
  и прописываем туда доступы к базе данных.

Открываем сайт в браузере. Удачной разработки!

## Использование примера

### Авторизационые данные

Используйте для авторизации:

* Логин: `admin`
* Пароль: `admin`

## Документация разработчика

**ВНИМАНИЕ**: _текстовая документация находится в процессе разработки, 
её содержимое может быть неполным, для лучшего понимания работы
системы обратитесь к [специальному разделу на сайте (там есть ссылки на видео)](http://fkn.ktu10.com/?q=node/9429)_.

1. [Введение](docs/Start.md)
2. [Конфигурация приложения](docs/Config.md)
3. [Маршрутизация](docs/Routing.md)
4. [Контроллеры](docs/Controllers.md)
5. [Модели](docs/Models.md)
6. [Представления](docs/Views.md)
7. [Макеты (Layouts) представлений](docs/Layouts.md)
8. [Авторизация и Конроль доступа. Работа с текущим пользователем](docs/AuthAndAccessControl.md)
9. [Система работы с JS и CSS и управления локальными зависимостями между файлами (Asset-ы)](docs/WorkingWithAssets.md)
10. (черновик) [Обработка исключений](docs/ExeptionsHandling.md)


### Использование данных конфигурационного файла

Подключаем клсс для работы с даными конфига:

```php
use ItForFree\SimpleMVC\Config;
```

Получение класса объекта (например, пользователя):

```php
$User = Config::getObject('core.user.class');
```
получение элемента (без необъходимости инстанцировать класс с таким именем):

```php
$User = Config::get('путь.в.массиве.конфига');
```

### Работа с объектом User

Получить доступ к объекту-синглтону можно так (через конфиг):

```php
$User = Config::getObject('core.user.class');
```

### Система контроля доступа

Получить подробную инфромацию о том почему есть или нет доступа к какому-либо  маршрутут для данного пользователя можно распечатав данные метода:
```php
$User->explainAccess('/ваш/маршрут');
```

## ToDo


### Не надо вникать

### Не надо вникать - мелкие правки

* `ItForFree\SimpleMVC\Url::link()` -- добавить вторым параметром список get-параметров, отличных от route

### Не надо вникать - более крупное

* Добавить типизацию везде, где только можно на ядро и приложение-пример
### Надо вникать


Что ещё надо улучшить/сделать (совсем универсальное выносим в rusphp остальное относится к ядру т.е. самому `SimpleMVC`):

Новые замечания:
* Добавить интерфейс для контроллеров (имеет смысл, если переделать свойство получения пути к макету на метод).

Старые замечания:
* Добавить html-хэлпер (возм. с участием `rusphp`)
* Несовершенный контроль доступа -- rules лучше сделать методом (чтобы, возможно, что-то вычислять динамически). 
    Ввести пседонимы @ и ? для роли зарегистрированного пользователя и гостя.
* Сделать  отдачу `404` в ответ на найденные контроллеры или их действия, аналогично подумать над передачей кодов для других ошибок (`исключений SimpleMVC`)
* Возможно, надо пересмотреть свзимоотношения трейта конторля доступа, контроллера и класса пользоватлея 
    -- м.б. трейт надо вынуть из контроллера и сделать либо независимым либо перенести в класс пользователя.
* Проверить работу класса, управляющего сессией, на предмет блокировок и "в целом".
* Добавить класс (виджет) для работы с меню, который мог бы выставлять активный элемент, проверяя маршрут.
* Прикрутить миграции.
* Добавить виджет для "хлебных крошек".
* Создать отдельно класс модели и отдельно класс модели для работы с БД (наследющийся от 1-ого).
* Описать интерфейсы для всех классов приложения, перечисленных в конфиге.
* Сделать объекты конфигурабельными.
* Проверить возможность установки явного времени действия сессии (авторизация).
* Сделать обработку ситуации отсутствия доступа более "мягкой" (без вообще непрехватываемого исключения).
* Добавить возможность редактирования роли пользователя, проверить стили на странице редактирования.



 

## Полезные материалы

* Документация по bootstrap4: https://getbootstrap.com/docs/4.1/layout/overview/
