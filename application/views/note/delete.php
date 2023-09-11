<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $deleteNoteTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/notes/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить заметку?
    
    <input type="hidden" name="id" value="<?= $deletedNote->id ?>">
    <input type="submit" name="deleteNote" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>