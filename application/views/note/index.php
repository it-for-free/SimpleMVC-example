<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-notes-nav.php'); ?>

<h2>List notes</h2>

<?php if (!empty($notes)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Оглавление</th>
      <th scope="col">Посвящается</th>
      <th scope="col">Дата</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($notes as $note): ?>
    <tr>
        <td> <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/notes/index&id=' 
		. $note->id . ">{$note->title}</a>" ) ?> </td>
        <td> <?= $note->content ?> </td>
        <td> <?= $note->publicationDate ?> </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php else:?>
    <p> Список заметок пуст</p>
<?php endif; ?>

