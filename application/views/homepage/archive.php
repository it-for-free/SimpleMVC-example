<h1><?php echo htmlspecialchars($results['pageHeading']) ?></h1>

    <?php if (isset($results['category']) && $results['category']): ?>
    <h3 class="categoryDescription"><?php echo htmlspecialchars($results['category']->description) ?></h3>
    <?php endif; ?>
    <ul id="headlines" class="archive">
    <?php foreach ($results['articles'] as $article): ?>
        <li>
                <h2>
                    <span class="pubDate">
                        <?php echo date('j F Y', $article->publicationDate) ?>
                    </span>
                    <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>">
                        <?php echo htmlspecialchars($article->title) ?>
                    </a>

                    <?php if ($article->categoryId): ?>
                    <span class="category">
                        in category
                        <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&categoryId=' . $article->categoryId) ?>">
                            <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name) ?>
                        </a>
                    </span>
                    <?php endif; ?>

                    <?php if ($article->subcategoryId): ?>
                    <span class="category">
                        in subcategory
                        <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&subcategoryId=' . $article->subcategoryId) ?>">
                            <?php echo htmlspecialchars($results['subcategories'][$article->subcategoryId]->subname) ?>
                        </a>
                    </span>
                    <?php endif; ?>

<?php if ($article->authors): ?>
                    <span class="category">
                        author<?php echo isset($article->authors[1]) ? 's' : '' ?>:
                        <?php echo implode(", ", $article->authors); ?>
                    </span>
<?php endif; ?>
                </h2>
                <p class="summary"><?php echo htmlspecialchars($article->summary) ?></p>
            </li>

    <?php endforeach; ?>
    </ul><!--'end_headlines'-->

        <p><?php echo $results['totalRows'] ?> article<?php echo ($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>

        <p><a href="/">Вернуться на главную страницу</a></p>
