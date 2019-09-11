<?php
    $query=<<<ROLES
            SELECT id, rol
            FROM roles;
ROLES;

    $aRoles=Hacer_query($query, 'select', 2);

    if(isset($_GET['user'])):
        $boton='Actualizar';
        $titulo='Editar usuario';
        $user=$_GET['user'];

        $query=<<<USUARIO
            SELECT nombre, apellido, usuario, email, pass, img, rol, img
            FROM usuarios
            JOIN roles ON usuarios.rol_id=roles.id
            WHERE usuarios.id=$user
USUARIO;

        $aUser=Hacer_query($query, 'select', 1);

        if(!$aUser):
            header('Location: panel.php?section=lista_panel');
            die();

        endif;

    else:
        $boton='Agregar';
        $titulo='Agregar usuario';

    endif;
?>
<section id='form_usuario'>
    <h2><?= $titulo ?></h2>

    <div class='error'>
        <?php 
             if(isset($_SESSION['error']) && $_SESSION['error']=== 'update_db'):
                echo $aErrores['update_db'];

            elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'agregar_db'):
                echo $aErrores['agregar_db'];

            endif;
        
        ?>
        
    </div>

    <form action="usuario_db.php" method='post' enctype='multipart/form-data'>
        <div>
            <label>
                <figure>
                    <img src="<?= isset($aUser) ? $aUser['img'] : 'img/usuarios/user_img.png' ?>" alt="<?= isset($aUser) ? $aUser['usuario'] : 'Usuario nuevo' ?>">
                </figure>

                <input type="file" name="img" accept='image/png, image/jpeg'>
            </label>
            <div class='error'>
            <?= isset($_SESSION['error']) && $_SESSION['error'] === 'type_img' ? $aErrores['type_img'] : ''; ?>
            </div>
        </div>

        <div>
            <div>
                <label>Nombre</label>
                <input type="text" name='nombre' value='<?= isset($aUser) ? $aUser['nombre'] : '' ?>'>
            </div>

            <div>
                <label>Apellido</label>
                <input type="text" name='apellido' value='<?= isset($aUser) ? $aUser['apellido'] : '' ?>'>
            </div>

            <div>
                <label>E-mail</label>
                <input type="email" name='email' value='<?= isset($aUser) ? $aUser['email'] : '' ?>'>
                <div class='error'>
                    <?php
                        if(isset($_SESSION['error']) && $_SESSION['error']==='email'):
                            echo $aErrores['email'];

                        elseif(isset($_SESSION['error']) && $_SESSION['error']==='email_existe'):
                            echo $aErrores['email_existe'];

                        endif;  
                    ?>
                </div>
            </div>

            <div>
                <label>Usuario</label>
                <input type="text" name='user' value='<?= isset($aUser) ? $aUser['usuario'] : '' ?>' <?= isset($aUser) ? 'disabled' : '' ?> >
                <div class='error'>
                    <?php
                        if(isset($_SESSION['error']) && $_SESSION['error']==='user'):
                            echo $aErrores['user'];

                        elseif(isset($_SESSION['error']) && $_SESSION['error']==='user_existe'):
                            echo $aErrores['user_existe'];

                        endif;  
                    ?>
                </div>
                    </div>
                <div>
                <label>Contraseña</label>
                <input type="password" name='pass' placeholder='******' <?= isset($aUser) ? 'disabled' : '' ?>>
                <div class='error'>
                <?= isset($_SESSION['error']) && $_SESSION['error'] === 'pass' ? $aErrores['pass'] : ''; ?>
                </div>
            </div>
            
            <div>
                <div id='rol_user'>
                    <label>Rol</label>
                    <select name="rol">
                        <option value="" disabled selected>Seleccionar Rol</option>

                        <?php
                            foreach($aRoles as $rol):
                        ?>

                            <option value="<?= $rol['id'] ?>" <?= isset($aUser) && $aUser['rol'] === $rol['rol'] ? 'selected' : ''  ?>><?= $rol['rol'] ?></option>

                        <?php
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class='error'>
                <?= isset($_SESSION['error']) && $_SESSION['error'] === 'rol' ? $aErrores['rol'] : ''; ?>
                </div>
            </div>

        </div>

        <input type="hidden" name="id" value='<?= isset($_GET['user']) ? $_GET['user'] : ''; ?>'>

        <input type="hidden" name="pass_user" value='<?= isset($aUser) ? $aUser['pass'] : '' ?>'>

        <input type="submit" value="<?= $boton; ?>">
    </form>
</section>