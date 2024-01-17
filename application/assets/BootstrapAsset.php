<?php
namespace application\assets;

use ItForFree\SimpleAsset\SimpleAsset;

/*
 * Класс для начальной автозагрузки необходимых ассетов
 */
class BootstrapAsset extends SimpleAsset {

   public $basePath = '/CSS/bootstrap';

   public $js = [
       'popper.js',
       'bootstrap.js'
    ];

    public $css = [
        'bootstrap.min.css'
    ];
}

