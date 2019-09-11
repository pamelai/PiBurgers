<?php
    require_once("config/config.php");
    require_once("config/functions.php");

    define('URL', 'index.php?section=registro');

    foreach($_POST as $dato => $valor):
        $aDatosPost[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));
        
        if(!empty($dato) && $dato !== 'pass' && $dato !== 'pass_conf' && $dato !== 'email_conf'):
            $_SESSION['datos'][$dato]=$valor;
        
        endif;

    endforeach;

    $nombre=$aDatosPost['nombre'] ? $aDatosPost['nombre']: null;
    $apellido=$aDatosPost['apellido'] ? $aDatosPost['apellido'] : null;
    $user=$aDatosPost['user'];
    $pass=$aDatosPost['pass'];
    $pass_conf=$aDatosPost['pass_conf'];
    $email=$aDatosPost['email'];
    $email_conf=$aDatosPost['email_conf'];


    if(empty($user)):
        $_SESSION['error']='user';

        header ('Location:'.URL);
        die();

    elseif(empty($pass)):
        $_SESSION['error']='pass';

        header ('Location:'.URL);
        die();

    elseif(empty($pass_conf)):
        $_SESSION['error']='pass_conf';

        header ('Location:'.URL);
        die();

    elseif($pass !== $pass_conf):
        $_SESSION['error']='pass_nocoincide';

        header ('Location:'.URL);
        die();
        
    elseif(empty($email)):
        $_SESSION['error']='email';

        header ('Location:'.URL);
        die();

    elseif(empty($email_conf)):
        $_SESSION['error']='email_conf';

        header ('Location:'.URL);
        die();

    elseif($email !== $email_conf):
        $_SESSION['error']='email_nocoincide';

        header ('Location:'.URL);
        die();

    endif;

    $query='SELECT usuario, email FROM usuarios;';

    $aDatos=Hacer_query($query, 'select', 2);

    foreach($aDatos as $dato):
        if($user === $dato['usuario']):
            $_SESSION['error']='user_existe';

            header('Location:'.URL);
            die();

        elseif($email === $dato['email']):
            $_SESSION['error']='email_existe';

            header('Location:'.URL);
            die();

        endif;
    endforeach;
    
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $query="INSERT INTO usuarios (nombre, apellido, img, email, pass, usuario, rol_id) VALUES (";

    if($nombre === null):
        $query.='null,';

    else:
        $query.="'$nombre',";
        
    endif;
    
    if($apellido === null):
        $query.='null,';

    else:
        $query.="'$apellido',";
        
    endif;

    $query.="'img/usuarios/user_img.png','$email', '$pass_hash', '$user', 2);";

    $insert=Hacer_query($query, 'insert', null);

    if($insert):
        $_SESSION['ok']='registro';
        header('Location:index.php?section=login');

        unset($_SESSION['datos']);
    
    else:
        $_SESSION['error']='registro';
        header('Location:'.URL);

    endif;