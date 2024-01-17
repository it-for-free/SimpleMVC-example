
            <form action="<?php echo $results['formAction'] ?>" method="post">
                <!-- <input type="hidden" name="id" value="<?php echo $results['article']->id ? $results['article']->id : "" ?>"> -->
                <?php echo $results['article']->id ? '<input type="hidden" name="id" value="' . $results['article']->id . '">' : "" ?>

        <?php if (isset($results['errorMessage'])): ?>
                <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php endif; ?>

                <ul>

                  <li>
                    <label for="title">Article Title</label>
                    <input type="text" name="title" id="title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php echo $results['article']->title ? htmlspecialchars($results['article']->title) : "" ?>" />
                  </li>

                  <li>
                    <label for="summary">Article Summary</label>
                    <textarea name="summary" id="summary" placeholder="Brief description of the article" required maxlength="1000" style="height: 5em;"><?php echo $results['article']->summary ? htmlspecialchars($results['article']->summary) : "" ?></textarea>
                  </li>

                  <li>
                    <label for="content">Article Content</label>
                    <textarea name="content" id="content" placeholder="The HTML content of the article" required maxlength="100000" style="height: 30em;"><?php echo $results['article']->content ? htmlspecialchars($results['article']->content) : "" ?></textarea>
                  </li>

                  <li>
                    <label for="categoryId">Article Subcat-ry</label>
                    <select name="categoryId">
                      <option value="0"<?php echo ($results['article']->categoryId == 0 && ! $results['article']->subcategoryId) ? " selected" : "" ?>>(none)</option>
                    <?php foreach ($results['categories'] as $category): ?>
                      <optgroup label="<?php echo $category->name ?>">
                          <option value="<?php echo $category->id ?>"<?php echo ($category->id == $results['article']->categoryId) ? " selected" : "" ?>>
                            без подкатегории
                          </option>
                        <?php foreach ($results['subcategories'] as $subcategory): ?>
                          <?php if ($subcategory->categoryId == $category->id): ?>
                          <option value="sub_<?php echo $subcategory->id ?>"<?php echo ($subcategory->id == $results['article']->subcategoryId) ? " selected" : "" ?>>
                            <?php echo htmlspecialchars($subcategory->subname) ?>
                          </option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </optgroup>
                    <?php endforeach; ?>
                    </select>
                  </li>

                  <li>
                    <label for="publicationDate">Publication Date</label>
                    <input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date("Y-m-d", $results['article']->publicationDate) : "" ?>" />
                  </li>

                  <li>
                    <label for="checkActivity">Active</label>
                    <input type="hidden" name="active" value="0">
                    <input id="checkActivity" type="checkbox" name="active" value="1"
                      <?php echo ! isset($results['article']->active) || $results['article']->active ? "checked" : "" ?> />
                  </li>

                  <li>  
                    <label for="authors[]">Autors</label>
                    <select name="authors[]" multiple>
                    <?php foreach ($results['users'] as $author): ?>
                        <option value="<?php echo $author->id ?>"<?php echo in_array($author->login, $results['article']->authors) ? " selected" : "" ?>><?php echo $author->login ?></option>
                    <?php endforeach; ?>
                    </select>
                  </li>

                </ul>

                <div class="buttons">
                  <input type="submit" name="saveChanges" value="Save Changes" />
                  <input type="submit" formnovalidate name="cancel" value="Cancel" />
                </div>

            </form>

    <?php if ($results['article']->id): ?>
        <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/delete&id=" . $results['article']->id) ?>" onclick="return confirm('Delete This Article?')">
                Delete This Article
            </a></p>
    <?php endif; ?>
