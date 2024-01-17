<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

        <h2>Список пользователей</h2>

<?php if (! empty($results['users'])): ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Логин</th>
                <th scope="col">Email</th>
                <th scope="col">Зарегистрирован</th>
                <th scope="col">Активность</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>

<?php foreach ($results['users'] as $user): ?>
            <tr>
                <td> <?= $user->id ?> </td>
                <td> <?= "<a href=\"" . $Url::link("admin/adminusers/index&id=" . $user->id . "\">{$user->login}</a>") ?> </td>
                <td> <?= $user->email ?> </td>
                <td> <?= $user->timestamp ?> </td>
                <td> <?= $user->active ? 'Yes' : 'No' ?> </td>
                <td> <?= $User->returnIfAllowed("admin/adminusers/edit",
                        "<a href=\"" . $Url::link("admin/adminusers/edit&id=" . $user->id) . "\">[Редактировать]</a>"); ?> </td>
            </tr>
<?php endforeach; ?>

            </tbody>
        </table>

        <p><?= $results['totalRows']?> user<?= ($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>

<?php else: ?>
        <p> Список пользователей пуст. </p>
<?php endif; ?>
