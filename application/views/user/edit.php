<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

        <h2><?= $results['user']->login ?>
            <span>
            <?= $User->returnIfAllowed("admin/adminusers/delete", 
                "<a href=\"" . $Url::link("admin/adminusers/delete&id=" . $results['user']->id) . "\">[Удалить]</a>"); ?>
            </span>
        </h2>

        <form action="<?= $Url::link("admin/adminusers/edit&id=" . $results['user']->id) ?>" method="post"> 
            <input type="hidden" name="id" value="<?= $results['user']->id ?>">

            <?php if (isset($results['errorMessage'])): ?>
                <div class="errorMessage"><?= $results['errorMessage'] ?></div>
            <?php endif; ?>

            <ul>

                <li>
                    <label for="login">User login</label>
                    <input type="text" name="login" id="login" placeholder="Login of the user" required autofocus maxlength="32" value="<?= htmlspecialchars($results['user']->login) ?>" />
                </li>

                <li>
                    <label for="password">User password</label>
                    <input type="text" name="pass" id="password" placeholder="Password of the user" autofocus maxlength="32" value="" />
                </li>

                <li>
                    <label for="email">User e-mail</label>
                    <input type="text" name="email" id="email" placeholder="Login of the user" required autofocus maxlength="32" value="<?= htmlspecialchars($results['user']->email) ?>" />
                </li>

                <li>
                    <label for="role">Задайте права доступа</label>
                    <select name="role" id="role"> 
                        <option value="auth_user"<?= $results['user']->role == 'auth_user' ? " selected" : "" ?>>Зарегистрированный пользователь</option>
                        <option value="admin"<?= $results['user']->role == 'admin' ? " selected" : "" ?>>Администратор</option>
                    </select>
                </li>

                <li>
                    <label for="checkActivity">User activity</label>
                    <input type="hidden" name="active" value="0" />
                    <input id="checkActivity" type="checkbox" name="active" value="1"
                    <?= ! isset($results['user']->active) || $results['user']->active ? "checked" : "" ?> />
                </li>

            </ul>

            <div class="buttons">
                <input type="submit" name="saveChanges" value="Save Changes" />
                <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>

        </form>

