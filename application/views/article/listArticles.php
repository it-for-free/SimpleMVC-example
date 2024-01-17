
          <table>
            <tr>
              <th>Publication Date</th>
              <th>Article</th>
              <th>Category</th>
              <th>Subcategory</th>
              <th>Autors</th>
              <th>Activity</th>
            </tr>

    <?php foreach ($results['articles'] as $article): ?>
        <!-- <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'"> -->
            <tr onclick="location='<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/edit&id=" . $article->id) ?>'">
              <td>
                <?php echo date('j M Y', $article->publicationDate)?>
              </td>
              <td>
                <?php echo $article->title?>
              </td>

              <td>

                <?php
                if (isset($results['subcategories'][$article->subcategoryId]->name)) {
                    echo $results['subcategories'][$article->subcategoryId]->name;
                } elseif (isset($results['categories'][$article->categoryId]->name)) {
                    echo $results['categories'][$article->categoryId]->name;
                } else {
                    echo "Без категории";
                } ?>
              </td>

              <td>
                <?php
                if (isset($results['subcategories'][$article->subcategoryId]->subname)) {
                    echo $results['subcategories'][$article->subcategoryId]->subname;
                } else {
                    echo "-";
                } ?>
              </td>

              <td>
                <?php
                if ($article->authors) {
                    echo implode(", ", $article->authors);
                } else {
                    echo "-";
                } ?>
              </td>

              <td>
                <?php echo $article->active ? 'Yes' : 'No'?>
              </td>
            </tr>

    <?php endforeach; ?>

          </table>

          <p><?php echo $results['totalRows']?> article<?php echo ($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>

          <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/add") ?>">Add a New Article</a></p>
