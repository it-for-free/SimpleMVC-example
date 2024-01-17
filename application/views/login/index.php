<form method="post" action="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('login/login') ?>" style="width: 50%">
            <!-- <input type="hidden" name="login" value="true" /> -->

<?php if (isset($_GET['auth'])): ?>
    <?php if ($_GET['auth'] == 'deny'): ?>
        <div class="errorMessage">Неправильный логин или пароль, попробуйте ещё раз.</div>
    <?php endif; ?>
    <?php if ($_GET['auth'] == 'blocked'): ?>
        <div class="errorMessage">Ваш аккаунт заблокирован, обратитесь к администратору.</div>
    <?php endif; ?>
<?php endif; ?>

            <ul>
                <li>
                    <label for="username">Username</label>
                    <input type="text" name="userName" id="username" placeholder="Your admin username" required autofocus maxlength="20" />
                </li>
                <li>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Your admin password" required maxlength="20" />
                </li>
            </ul>

            <div class="buttons">
                <input type="submit" name="login" value="Войти" />
            </div>

        </form>

