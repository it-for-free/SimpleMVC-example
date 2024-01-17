<h1 style="width: 75%;"><?php echo htmlspecialchars($results['pageHeading']) ?></h1>

        <div style="width: 75%; font-style: italic;"><?php echo htmlspecialchars($results['article']->summary) ?></div>
        <div style="width: 75%;"><?php echo $results['article']->content ?></div>

        <p class="pubDate">Published on <?php echo date('j F Y', $results['article']->publicationDate) ?>

        <?php if (isset($results['category']) && $results['category']): ?>
            in category
            <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&categoryId=' . $results['category']->id)  ?>">
                <?php echo htmlspecialchars($results['category']->name) ?>
            </a>
        <?php endif; ?>
        <?php if (isset($results['subcategory']) && $results['subcategory']): ?>
            in subcategory
            <a href="<?php echo \ItForFree\SimpleMVC\Router\WebRouter::link('homepage/archive&subcategoryId=' . $results['subcategory']->id) ?>">
                <?php echo htmlspecialchars($results['subcategory']->subname) ?>
            </a>
        <?php endif; ?>

        <?php if ($results['article']->authors): ?>
        <span style="font-size: 80%;" class="category">
            author<?php echo isset($results['article']->authors[1]) ? 's' : '' ?>: 
            <?php echo implode(", ", $results['article']->authors); ?>
        </span>
        <?php endif; ?>
        </p>

        <p><a href="/">Вернуться на главную страницу</a></p>
