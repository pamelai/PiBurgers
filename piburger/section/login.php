<?php
    if(isset($_SESSION['user'])):
        header('Location: index.php?section=home');
        die();

    endif;

?>

<div id='login' class="encabezado">
    <h2>Log-in</h2>
</div>
<section>
    <div class='<?= Class_msj() ?>'>
        <?php 
            if(isset($_SESSION['ok'])):
                echo $aOks['registro'];

            elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'user_incorrecto'):
                echo $aErrores['user_incorrecto'];
                
            endif;
        ?>
    </div>
    

    <form action="logeo.php" method='post'>
        <label>Usuario o e-mail</label>
        <input type="text" name="user">
        <div class='error'> <?= isset($_SESSION['error']) && $_SESSION['error'] === 'user_login' ? $aErrores['user_login'] : ''; ?> </div>

        <label>Contraseña</label>
        <input type="password" name="pass">
        <div class='error'> <?= isset($_SESSION['error']) && $_SESSION['error'] === 'pass_login' ? $aErrores['pass_login'] : ''; ?> </div>

        <input type="submit" value="Ingresar">

    </form>

    <p>¿No estas registrado? <a href="index.php?section=registro">Registrate</a> </p>
</section>