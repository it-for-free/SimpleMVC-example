<?php if (isset($results['errorMessage'])): ?>
<h1 style="width: 75%;">[!] Произошла ОШИБКА</h1>
        <div style="width: 75%; font-style: italic;"> Текст ошибки:</div>
        <div style="width: 75%;"><?php echo $results['errorMessage'] ?></div>

        <p><a href="./">Вернуться на главную страницу</a></p>
<?php else: ?>
<div class="card-header"><h1><?= $status?></h1> <?=$message?></div>

        <div class="card-body">
            <table class="table table-striped table-dark">
            <?php foreach ($trace as $key=>$value):?> 
                <tr>
                    <td><?=$value['file']?></td>
                    <td width="10%"><?=$value['line']?></td>
                    <td><?=$value['function']?></td>
                    <td><?=$value['class']?></td>
                </tr>
            <?php endforeach;?>
            </table>
        </div>
<?php endif; ?>
