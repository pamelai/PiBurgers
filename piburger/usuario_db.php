<?php
    require_once('config/config.php');
    require_once('config/functions.php');
    require_once('config/arrays.php');

    foreach($_POST as $dato => $valor):
        $aDatosPost[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));
        
    endforeach;

    $nombre=$_POST['nombre'] ? $_POST['nombre']: null;
    $apellido=$_POST['apellido'] ? $_POST['apellido'] : null;
    $email=$_POST['email'];
    if(isset($_POST['user'])):
        $user=$_POST['user'];
    endif;
    $rol=$_POST['rol'];
    $id=$_POST['id'];
    if(empty($id)):
        $pass=$_POST['pass'];
    
    else:
        $pass=$_POST['pass_user'];

    endif;

    if(empty($id)):
        define('URL', 'panel.php?section=form_usuario');

    else:  
        define('URL', "panel.php?section=form_usuario&user=$id");

    endif;
    

    if(empty($email)):
        $_SESSION['error']='email';
        header('Location:'. URL);
        die();

    elseif(isset($_POST['user']) && empty($user)):
        $_SESSION['error']='user';
        header('Location:'. URL);
        die();

    elseif(isset($_POST['pass']) && empty($pass)):
        $_SESSION['error']='pass';
        header('Location:'. URL);
        die();

    elseif(empty($rol)):
        $_SESSION['error']='rol';
        header('Location:'. URL);
        die();

    endif;


    $rutaImagen='img/usuarios/user_img.png';

    if(!empty($_FILES['img']) && $_FILES['img']['error'] === 0):
        $img=$_FILES['img'];
        
        if(in_array($img['type'], $aType_img)):
            $type=explode('/', $img['type'])[1];

        else:
            $_SESSION['error']='type_img';

            header("Location:".URL);
            die();

        endif;
        
        $abrirImg="imagecreatefrom$type";
        $imgOrig= $abrirImg($img['tmp_name']);

        $anchoOrig=imagesx($imgOrig);
        $altoOrig=imagesy($imgOrig);

        $anchoNew=300;
        $altoNew= 300;

        $lienzoNew=imagecreatetruecolor($anchoNew, $altoNew);

        if($type != 'jpeg'):
            imagesavealpha($lienzoNew,true);
            imagealphablending($lienzoNew,false);
        endif;

        imagecopyresampled($lienzoNew,$imgOrig,0,0,0,0,$anchoNew,$altoNew,300,300);

        header("Content-type:image/$type");

        if(!is_dir("img/usuarios/$email")):
            mkdir("img/usuarios/$email");

        endif;

        $export = "image$type";

        if($type == "jpeg"):
            $calidad = 75;

        else:
            $calidad = 7;

        endif;

        $export($lienzoNew,"img/usuarios/$email/avatar.$type",$calidad);

        $rutaImagen = "img/usuarios/$email/avatar.$type";

    endif;
    

    $query='SELECT id, email FROM usuarios;';

    $aDatos=Hacer_query($query, 'select', 2);

    foreach($aDatos as $dato):
        if($email === $dato['email'] && $id !== $dato['id']):
            $_SESSION['error']='email_existe';

            header('Location:'.URL);
            die();

        endif;
    endforeach;

    if(empty($id)):
        foreach($_POST as $dato => $valor):
            if(!empty($dato) && $dato !== 'pass'):
                $_SESSION['datos'][$dato]=$valor;
            
            endif;
    
        endforeach;

        $pass_hash=password_hash($pass, PASSWORD_DEFAULT);

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
    
        $query.="'$rutaImagen','$email', '$pass_hash', '$user', $rol);";

        $rta=Hacer_query($query, 'insert', null);

        $ok='agregar_db';
        $error='agregar_db';
    
    else:
        
        $query=<<<IMG
            SELECT img
            FROM usuarios
            WHERE id=$id;
IMG;

        $imagen=Hacer_query($query, 'select', 1);

        if($imagen['img'] !== null && $imagen['img'] !== 'img/usuarios/user_img.png'):
            $rutaImagen=$imagen['img'];

        endif;   
 
        $query="UPDATE usuarios SET ";

        if($nombre === null):
            $query.='nombre=null,';
    
        else:
            $query.="nombre='$nombre',";
            
        endif;
        
        if($apellido === null):
            $query.='apellido=null,';
    
        else:
            $query.="apellido='$apellido',";
            
        endif;

        $query.="img='$rutaImagen', email='$email', rol_id=$rol WHERE id=$id;";


        $rta=Hacer_query($query, 'update', null);

        $ok='update_db';
        $error='update_db';

    endif;

    if($rta):
        $_SESSION['ok']=$ok;
        header('Location:panel.php?section=lista_panel');

        unset($_SESSION['datos']);

    else:
        $_SESSION['error']=$error;
        header('Location:'.URL);
        
    endif;