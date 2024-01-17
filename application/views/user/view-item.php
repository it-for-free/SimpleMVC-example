<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

        <h2><?= $viewAdminuser->login ?>
            <span>
            <?= $User->returnIfAllowed("admin/adminusers/edit", 
                "<a href=\"" . $Url::link("admin/adminusers/edit&id=" . $viewAdminuser->id) . "\">[Редактировать]</a>"); ?>
            </span>
        </h2>

        <p>Зарегистрирован: <?= $viewAdminuser->timestamp ?></p>
        <p>E-mail: <?= $viewAdminuser->email ?></p>
        <p>Права доступа: <?=
                $viewAdminuser->role == 'auth_user' ? "Зарегистрированный пользователь" : "" ?><?=
                $viewAdminuser->role == 'admin' ? "Администратор" : "" ?></p>
        <p>Активность: <?= ! isset($viewAdminuser->active) || $viewAdminuser->active ? "Активен" : "Заблокирован" ?></p>
