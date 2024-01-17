
        <form action="<?php echo $results['formAction'] ?>" method="post"> 
            <!-- <input type="hidden" name="subcategoryId" value="<?php echo $results['subcategory']->id ?>"/> -->
            <?php echo $results['subcategory']->id ? '<input type="hidden" name="id" value="' . $results['subcategory']->id . '">' : "" ?>

    <?php if (isset($results['errorMessage'])): ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php endif; ?>

            <ul>
              <li>
                <label for="name">Subcategory Name</label>
                <input type="text" name="subname" id="name" placeholder="Name of the subcategory" required autofocus maxlength="255" value="<?php echo $results['subcategory']->subname ? htmlspecialchars($results['subcategory']->subname) : "" ?>" />
              </li>
              <li>
                <label for="categoryId">Contain Category</label>
                <select name="categoryId">
    <?php foreach ($results['categories'] as $category): ?>
                  <option value="<?php echo $category->id ?>"<?php echo ($results['subcategory']->categoryId == $category->id) ? " selected" : "" ?>>
                        <?php echo htmlspecialchars($category->name) ?>
                  </option>
    <?php endforeach; ?>
                </select>
              </li>
            </ul>

            <div class="buttons">
              <input type="submit" name="saveChanges" value="Save Changes" />
              <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>

        </form>

    <?php if ($results['subcategory']->id): ?>
    <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/delete&id=" . $results['subcategory']->id) ?>" onclick="return confirm('Delete This Subcategory?')">
            Delete This Subcategory
        </a></p>
    <?php endif; ?>
