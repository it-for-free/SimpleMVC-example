<h1><?php echo htmlspecialchars($results['pageHeading']) ?></h1>

        <ul id="headlines">
    <?php foreach ($results['articles'] as $article): ?>
        <li class="<?php echo $article->id ?>">
                <h2>
                    <span class="pubDate">
                        <?php echo date('j F', $article->publicationDate) ?>
                    </span>

                    <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>">
                        <?php echo htmlspecialchars($article->title) ?>
                    </a>

                    <?php if (isset($results['categories'][$article->categoryId]->name)): ?>
                        <span class="category">
                            in
                            <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&categoryId=' . $article->categoryId) ?>">
                                <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name) ?>
                            </a>
                        </span>
                    <?php elseif (isset($article->subcategoryId)): ?>
                        <span class="category">
                            in
                            <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&categoryId=' . $results['subcategories'][$article->subcategoryId]->categoryId) ?>">
                                <?php echo htmlspecialchars($results['subcategories'][$article->subcategoryId]->name) ?>
                            </a>
                        </span>
                    <?php else: ?>
                        <span class="category">
                            <?php echo "Без категории" ?>
                        </span>
                    <?php endif; ?>

                    <?php if (isset($article->subcategoryId)): ?>
                        <span class="category">
                            in
                            <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&subcategoryId=' . $article->subcategoryId) ?>">
                                <?php echo htmlspecialchars($results['subcategories'][$article->subcategoryId]->subname) ?>
                            </a>
                        </span>
                    <?php else: ?>
                        <span class="category">
                            <?php echo "Без подкатегории" ?>
                        </span>
                    <?php endif; ?>

<?php if ($article->authors): ?>
                    <span class="category">
                        author<?php echo isset($article->authors[1]) ? 's' : '' ?>:
                        <?php echo implode(", ", $article->authors); ?>
                    </span>
<?php endif; ?>
                </h2>

                <p class="summary">
                    <?php
                        $str = htmlspecialchars($article->content);
                        mb_strlen($str, 'utf-8') > 53 ? $chars50 = rtrim(mb_substr($str, 0, 50, 'utf-8')) . '...' : $chars50 = $str;
                        echo $chars50;
                    ?>
                </p>
                <img id="loader-identity-<?php echo $article->id ?>" class="loader-identity" src="JS/ajax-loader.gif" alt="gif">

                <ul class="ajax-load">
                    <li><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>"
                        class="ajaxArticleBodyByPost" data-contentId="<?php echo $article->id ?>">Показать продолжение (POST)</a></li>
                    <li><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>"
                        class="ajaxArticleBodyByGet" data-contentId="<?php echo $article->id ?>">Показать продолжение (GET)</a></li>
                    <li><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>"
                        class="ajaxByPost" data-articleId="<?php echo $article->id ?>">(POST) -- NEW</a></li>
                    <li><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>"
                        class="ajaxByGet" data-articleId="<?php echo $article->id ?>">(GET) -- NEW</a></li>
                </ul>

                <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/viewArticle&articleId=' . $article->id) ?>"
                    class="showContent" data-contentId="<?php echo $article->id ?>">Показать полностью</a>
            </li>

    <?php endforeach; ?>
    </ul><!--'end_headlines'-->

        <p><a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive') ?>">Архив статей</a></p>
