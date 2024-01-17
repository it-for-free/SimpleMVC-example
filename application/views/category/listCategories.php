
<table>
    <tr>
        <th>Category</th>
    </tr>

<?php foreach ($results['categories'] as $category): ?>
    <!-- <tr onclick="location='admin.php?action=editCategory&amp;categoryId=<?php echo $category->id ?>'"> -->
    <tr onclick="location='<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/edit&id=" . $category->id) ?>'">
        <td>
            <?php echo $category->name ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>

<p><?php echo $results['totalRows'] ?> categor<?php echo ($results['totalRows'] != 1) ? 'ies' : 'y' ?> in total.</p>

<p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/add") ?>">Add a New Category</a></p>
