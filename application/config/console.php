<?php
/**
 * Конфигурационной файл консольного приложения
 */
$config = [
    'core' => [ // подмассив, используемый самим ядром фреймворка
        'db' => [
            'dns' => 'mysql:host=localhost;dbname=dbname',
            'username' => 'root',
            'password' => '1234'
        ],
        'router' => [ // подсистема маршрутизации
            'class' => \ItForFree\SimpleMVC\Router\ConsoleRouter::class,
	    'alias' => '@router'
        ]
    ]    
];

return $config;