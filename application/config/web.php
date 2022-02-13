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
            'alias' => '@session'
        ]
    ]    
];

return $config;