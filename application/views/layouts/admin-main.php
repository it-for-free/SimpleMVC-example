<?php
use ItForFree\SimpleAsset\SimpleAssetManager;
?>
<!DOCTYPE html>
<html>
<?php include('includes/main/head.php'); ?>

<body>
    <div id="container">
        <?php include('includes/main/logo.php'); ?>
        <?php include('includes/admin-main/nav.php'); ?>
        <?php include('includes/admin-main/message.php'); ?>

        <?= $CONTENT_DATA ?>

        <?php include('includes/admin-main/footer.php'); ?>
    </div><!--'end_container'-->

    <?php
        // класс CustomJavascriptAsset подключает jquery-3.2.1.js и NewMyJS.js из папки web/JS/
        // а метод printJS() выведет popper.js и bootstrap.js из папки web/CSS/bootstrap (задействуется класс BootstrapAsset)
        SimpleAssetManager::printJS();
    ?>
</body>

</html>
