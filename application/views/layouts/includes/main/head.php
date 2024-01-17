<?php 
// SimpleAssetManager.php находится в папке /vendor/it-for-free/php-simple-assets/src
use ItForFree\SimpleAsset\SimpleAssetManager;
// в классе CustomCSSAsset подключается класс BootstrapAsset, который подключает popper.js и bootstrap.js из папки web/CSS/bootstrap
use application\assets\CustomCSSAsset;
// класс CustomJavascriptAsset подключает jquery-3.2.1.js и NewMyJS.js из папки web/JS
use application\assets\CustomJavascriptAsset;

?>

<head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    <!-- <title>SimpleMVC | Учебный проект</title> -->
<?php if (isset($results['pageTitle'])): ?>
    <title><?php echo htmlspecialchars($results['pageTitle']) ?></title>
<?php endif; ?>

    <?php
        // обязательно сначала выполним метод, подключающий библитотеку jquery
        CustomJavascriptAsset::add();
        CustomCSSAsset::add();
        SimpleAssetManager::printCss();
    ?>
</head>
