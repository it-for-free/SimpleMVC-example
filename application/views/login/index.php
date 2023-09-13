<h2><?= $loginTitle ?></h2>

<form method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('login/login')?>">
    
    <?php 
    if (!empty($_GET['auth'])) {
        echo "Неверное имя пользователя или пароль";
    }
    ?>
    <div class="form-group">
        <label for="userName" >Введите имя пользователя</label>
        <input type="text"  class="form-control" id="userName"  name="userName" >
    </div>
    <div class="form-group">
        <label for="password" >Введите пароль</label>
        <input type="password" name="password"  class="form-control" id="userName"  name="userName" >
    </div>
    <input type="submit" class="btn btn-primary" name="login" value="Сохранить">
   
</form>

