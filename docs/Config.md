
# Конфигурация приложения. SimpleMVC

* Конфигурация приложения задается в файле `application/config/web.php` и содержит  в основном значения, которые используются Ядром приложения, этот файл имеет вид ([см. исходный код](https://github.com/it-for-free/SimpleMVC-example/blob/master/application/config/web.php#L1)):
```php
<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'db' => [
            'dns' => 'mysql:host=localhost;dbname=dbname',
            'username' => 'root',
            'password' => '1234'
        ],
        'router' => [ // подсистема маршрутизация
            'class' => \ItForFree\SimpleMVC\Router::class,
	    'alias' => '@router'
        ],
        'url' => [ 
            'class' => \ItForFree\SimpleMVC\Url::class
        ],
        'mvc' => [ // настройки MVC
            'views' => [
                'base-template-path' => '../application/views/',
                'base-layouts-path' => '../application/views/layouts/',
                'footer-path' => '',
                'header-path' => ''
            ]
        ],
        'handlers' => [ // подсистема перехвата исключений
            'ItForFree\SimpleMVC\exceptions\SmvcAccessException' 
		=> \application\handlers\UserExceptionHandler::class,
            'ItForFree\SimpleMVC\exceptions\SmvcRoutingException' 
		=> \application\handlers\UserExceptionHandler::class
        ],
        'user' => [ // подсистема авторизации
            'class' => \application\models\ExampleUser::class,
	        'construct' => [
                'session' => '@session',
                'router' => '@router'
             ], 
        ],
        'session' => [ // подсистема работы с сессиями
            'class' => ItForFree\SimpleMVC\Session::class,
            'alias' => '@session' // назначаем псевдоним
        ]
    ]    
];

return $config;
```

* Чтобы переопределить необходимые вам значений, используйте локальный конфиг `application/config/web-local.php`, например для _переопределения_ настроек БД нужен будет код вида (используем _те же самые ветки массива_, что и в основном конфиге, но _с новыми значениями_):
```php
<?php

$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'db' => [ // подмассив конфигурации БД
            'dns' => 'mysql:host=localhost;dbname=smvc',
            'username' => 'root',
            'password' => '12345'
        ]
    ]    
];
return $config;
```

## Контейнер

**Контейнером** называют часть приложения, ответственную за хранение и "выдачу" (по запросу) разных частей приложения.

В SMVC за работу контейнера отвечает класс Ядра `\ItForFree\SimpleMVC\Config` ([исх. код](https://github.com/it-for-free/SimpleMVC/blob/master/src/Config.php#L1))

## Получение компонентов из конфига

Чтобы получить необходимый компонент из котейнера, достаточно передать "путь" к этому элементу в многомерном массиве конфигурации в виде строки, где ключи массива, разделяются точками, например для получения объекта текущего пользователя:

```php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
```

## Инъекция зависимостей (DI - dependency Injection)

Контенер SMVC поддерживает паттерн "Инъекция зависимостей", это означает,
что Контейнер может "инъектировать" сущности от которых зависит этот объект прямо внутрь этого объекта (напр, передав их в конструктор, при создании этого объета).

Рассмотрим пример из конфигурации выше, так компонент "пользователь", для своего конструирования требует передачи в конструктор двух компонентов -- сессии и маршрутизатора (router):

```php
'user' => [ // подсистема авторизации
    'class' => \application\models\ExampleUser::class,
    'construct' => [
        'session' => '@session',
        'router' => '@router'
        ], 
],
```

-- для того, чтобы отличать ссылку на компонент от обычной строки мы используем **псевдонимы** - это те же строки, но _начинающиеся с собаки_ `@`.
Чтобы псевдоним использовать, но должен быть назначен для какого-то компонента, напр. как это сделано для компонента сессии:

```php
'session' => [ // подсистема работы с сессиями
    'class' => ItForFree\SimpleMVC\Session::class,
    'alias' => '@session' // назначаем псевдоним
]
```

Главным преимуществом использования DI на практике является то, что вы можете взять любой класс и использовать его в проекте (даже если этот класс требует какие-то параметры для конструирования), этот класс не обязан "знать" о существовании псевдоним контейнера `Config` (см. выше) для получения нужных ему для работы значений, т.к. блогадря DI он еще до использования будет создан/сконфигурирован с добавлением (инъекцией) всех этих значений.

В данный момент DI в SMVC поддерживает:
* Передачу параметров в конструктор
* Установку `public`-свойств

Подробнее реализацию поддержки DI можно посмотреть в исходном коде ядра SimpleMVC (класс `Application` [исх. код](https://github.com/it-for-free/SimpleMVC/blob/master/src/Application.php#L1))












