<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>

        <div id="adminHeader">
            <h2>Widget News Admin</h2>

            <p>You are logged in as <b><?php echo htmlspecialchars($User->userName) ?></b>.
<?php if ($User->isAllowed("login/login")): ?>
                <a href="<?= WebRouter::link("login/login") ?>">[Вход]</a>
<?php endif; ?>
<?php if ($User->isAllowed("admin/articles/index")): ?>
                <a href="<?= WebRouter::link("admin/articles/index") ?>">Show Articles</a>
<?php endif; ?>
<?php if ($User->isAllowed("admin/categories/index")): ?>
                <a href="<?= WebRouter::link("admin/categories/index") ?>">Show Categories</a>
<?php endif; ?>
<?php if ($User->isAllowed("admin/subcategories/index")): ?>
                <a href="<?= WebRouter::link("admin/subcategories/index") ?>">Show Subcategories</a>
<?php endif; ?>
<?php // if ($User->userName == 'admin') { ?>
<?php if ($User->isAllowed("admin/adminusers/index")): ?>
                <a href="<?= WebRouter::link("admin/adminusers/index") ?>">Show Users</a>
<?php // } ?>
<?php endif; ?>
<?php if ($User->isAllowed("login/logout")): ?>
                <a href="<?= WebRouter::link("login/logout") ?>">Log Out</a>
<?php endif; ?>
            </p>
        </div>

