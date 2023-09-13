<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php include('includes/admin-notes-nav.php'); ?>
<h2><?= $addNoteTitle ?></h2>

<form id="addNote" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/add")?>"> 
    <div class="form-group">
        <label for="title">Название новой заметки</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="имя заметки">
    </div>
    <div class="form-group">
        <label for="content">Содержание</label><br>
        <textarea type="description" name="content" placeholred="описание заметки"  value=></textarea>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNewNote" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>    
