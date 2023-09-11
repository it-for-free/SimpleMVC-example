<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

<h2><?= $deleteAdminusersTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/adminusers/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить данные пользователя?
    
    <input type="hidden" name="id" value="<?= $deletedAdminusers->id ?>">
    <input type="submit" name="deleteUser" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>
