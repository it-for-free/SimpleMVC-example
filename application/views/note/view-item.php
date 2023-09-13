<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $viewNotes->title ?>
    <span>
        <?= $User->returnIfAllowed("admin/notes/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/edit&id=". $viewNotes->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/notes/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/delete&id=". $viewNotes->id)
            .    ">[Удалить]</a>"); ?>
    </span>
    
</h2> 

<p>Контент: <?= $viewNotes->content ?></p>
<p>Зарегестрирована: <?= $viewNotes->publicationDate ?></p>

