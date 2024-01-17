<h1><?php echo $results['pageTitle'] ?></h1>

<?php if (isset($results['errorMessage'])) { ?>
    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if (isset($results['statusMessage'])) { ?>
    <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>
