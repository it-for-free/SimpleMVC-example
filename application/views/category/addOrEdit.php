
        <form action="<?php echo $results['formAction'] ?>" method="post"> 
            <!-- <input type="hidden" name="categoryId" value="<?php echo $results['category']->id ?>"/> -->
            <?php echo $results['category']->id ? '<input type="hidden" name="id" value="' . $results['category']->id . '">' : "" ?>

    <?php if (isset($results['errorMessage'])): ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
    <?php endif; ?>

            <ul>
              <li>
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" placeholder="Name of the category" required autofocus maxlength="255" value="<?php echo $results['category']->name ? htmlspecialchars($results['category']->name) : "" ?>" />
              </li>
              <li>
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Brief description of the category" required maxlength="1000" style="height: 5em;"><?php echo $results['category']->description ? htmlspecialchars($results['category']->description) : "" ?></textarea>
              </li>
            </ul>

            <div class="buttons">
              <input type="submit" name="saveChanges" value="Save Changes" />
              <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>

        </form>

    <?php if ($results['category']->id): ?>
    <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/delete&id=" . $results['category']->id) ?>" onclick="return confirm('Delete This Category?')">
            Delete This Category
        </a></p>
    <?php endif; ?>
