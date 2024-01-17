<?php
namespace application\assets;

use ItForFree\SimpleAsset\SimpleAsset;
use application\assets\BootstrapAsset;

/*
 * Класс ассет для библиотеки Джиквери
 */
class JqueryAsset extends SimpleAsset {

    public $basePath = '/';

    public $js = [
        'JS/jquery-3.2.1.js'
    ];
}

