<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>
<div id="footer">
            Простая PHP CMS &copy; 2017. Все права принадлежат всем. ;)
            <?= $User->returnIfAllowed("login/login", 
                "<a href=\"" . $Url::link("login/login") . "\">Site Admin</a>"); ?>
            <?= $User->returnIfAllowed("login/logout", 
                "<a href=\"" . $Url::link("admin/articles/index") . "\">Site Admin</a>"); ?>

        </div>
            
