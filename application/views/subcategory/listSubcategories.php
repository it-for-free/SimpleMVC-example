
<table>
    <tr>
        <th>Subcategory</th>
    </tr>

<?php foreach ($results['subcategories'] as $subcategory): ?>
    <!-- <tr onclick="location='admin.php?action=editSubcategory&amp;subcategoryId=<?php echo $subcategory->id ?>'"> -->
    <tr onclick="location='<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/edit&id=" . $subcategory->id) ?>'">
        <td>
            <?php echo $subcategory->subname ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>

<p><?php echo $results['totalRows'] ?> subcategor<?php echo ($results['totalRows'] != 1) ? 'ies' : 'y' ?> in total.</p>

<p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/add") ?>">Add a New Subcategory</a></p>
