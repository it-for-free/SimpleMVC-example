<?php
namespace application\assets;

use ItForFree\SimpleAsset\SimpleAsset;
use application\assets\JqueryAsset;

/*
 * Класс ассет для ДжаваСкрипт пользовательский
 */
class CustomJavascriptAsset extends SimpleAsset {

    public $basePath = '/';

    public $js = [
        'JS/NewMyJS.js',
        'JS/showContent.js',
        'JS/loaderIdentity.js'
    ];

    public $needs = [
        JqueryAsset::class
    ];
}

