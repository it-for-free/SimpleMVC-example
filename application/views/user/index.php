<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-users-nav.php'); ?>

<h2>Список пользователей</h2> 
    
<?php if (!empty($users)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Логин</th>
      <th scope="col">Email</th>
      <th scope="col">Зарегистрирован</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($users as $user): ?>
    <tr>
        <td> <?= $user->id ?> </td>
        <td> <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/adminusers/index&id=' 
		. $user->id . ">{$user->login}</a>" ) ?> </td>
        <td>  <?= $user->email ?> </td>
        <td>  <?= $user->timestamp ?> </td>
        <td>  <?= $User->returnIfAllowed("admin/adminusers/edit",
                    "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/adminusers/edit&id=". $user->id) 
                    . ">[Редактировать]</a>");?></td>
    </tr>
    <?php endforeach; ?>
    
    </tbody>
</table>

<?php else:?>
    <p> Список пользователей пуст. </p>
<?php endif; ?>