<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

<?php
// Узнаем роль пользователя (т.к. в классе UserModel $role задана с модификатором protected, поэтому так сложно)
if (isset($viewAdminusers->role)) {
    $role = $viewAdminusers->role;
} else {
    $array = (array)$viewAdminusers;
    $prefix = chr(0) . '*' . chr(0);
    $role = $array[$prefix . 'role'];
}
// echo $role;
?>

<h2><?= $editAdminusersTitle ?>
    <span>
        <?= $User->returnIfAllowed("admin/adminusers/delete", 
            "<a href=" . $Url::link("admin/adminusers/delete&id=" . $_GET['id']) 
            . ">[Удалить]</a>");?>
    </span>
</h2>

<form id="editUser" method="post" action="<?= $Url::link("admin/adminusers/edit&id=" . $_GET['id'])?>">
    <h5>Введите имя пользователя</h5>
    <input type="text" name="login" placeholder="логин пользователя" value="<?= $viewAdminusers->login ?>"><br>
    <h5>Введите пароль</h5>
    <input type="text" name="pass" placeholder="новый пароль" value=""><br>

    <h5>Задайте права доступа</h5>  
    <select name="role"> 
        <option value="admin"<?php echo $role == 'admin' ? " selected" : "" ?>>Администратор</option>
        <option value="auth_user"<?php echo $role == 'auth_user' ? " selected" : "" ?>>Зарегистрированный пользователь</option>
    </select>

    <h5>Введите e-mail</h5>
    <input type="text" name="email"  placeholder="email" value="<?= $viewAdminusers->email ?>"><br>

    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    <input type="submit" name="saveChanges" value="Сохранить">
    <input type="submit" name="cancel" value="Назад">
</form>
