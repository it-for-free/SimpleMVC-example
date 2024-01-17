<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-users-nav.php'); ?>

        <form action="<?= $Url::link("admin/adminusers/add") ?>" method="post"> 

            <?php if (isset($results['errorMessage'])): ?>
                <div class="errorMessage"><?= $results['errorMessage'] ?></div>
            <?php endif; ?>

            <ul>

                <li>
                    <label for="login">User login</label>
                    <input type="text" name="login" id="login" placeholder="Login of the user" required autofocus maxlength="32" value="" />
                </li>

                <li>
                    <label for="password">User password</label>
                    <input type="text" name="pass" id="password" placeholder="Password of the user" required autofocus maxlength="32" value="" />
                </li>

                <li>
                    <label for="email">User e-mail</label>
                    <input type="text" name="email" id="email" placeholder="Login of the user" required autofocus maxlength="32" value="" />
                </li>

                <li>
                    <label for="role">Задайте права доступа</label>
                    <select name="role" id="role">
                        <option value="auth_user">Зарегистрированный пользователь</option>
                        <option value="admin">Администратор</option>
                    </select>
                </li>

                <li>
                    <label for="checkActivity">User activity</label>
                    <input type="hidden" name="active" value="0" />
                    <input id="checkActivity" type="checkbox" name="active" value="1"/>
                </li>

            </ul>

            <div class="buttons">
                <input type="submit" name="saveNewUser" value="Add new User" />
                <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>

        </form>
