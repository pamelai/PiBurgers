<?php
    require_once('config/config.php');
    require_once('config/functions.php');
    require_once('config/arrays.php');

    foreach($_POST as $dato => $valor):
           $aDatosPost[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));
           
    endforeach;

    $nombre=$aDatosPost['nombre'];
    $descripcion=$aDatosPost['descripcion'];
    $tipo=$aDatosPost['tipo'];
    $id=$aDatosPost['id'];
    $precio=$aDatosPost['precio'];

    if(empty($id)):
        define('URL', 'panel.php?section=form_plato');

    else:  
        define('URL', "panel.php?section=form_plato&plato=$id");

    endif;

    if(isset($nombre) && empty($nombre)):
        $_SESSION['error']='nombre';
        header('Location:'. URL);
        die();

    elseif(isset($tipo) && empty($tipo)):
        $_SESSION['error']='tipo';
        header('Location:'. URL);
        die();

    elseif(isset($descripcion) && empty($descripcion)):
        $_SESSION['error']='desc';
        header('Location:'. URL);
        die();

    elseif(isset($precio) && empty($precio)):
        $_SESSION['error']='precio';
        header('Location:'. URL);
        die();

    endif;

    if(!empty($_FILES['img']) && $_FILES['img']['error'] === 0):
        $img=$_FILES['img'];
        
        if($img['type'] === 'image/jpeg'):
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

        $anchoNew=250;
        $altoNew= 250;

        $lienzoNew=imagecreatetruecolor($anchoNew, $altoNew);

        imagecopyresampled($lienzoNew,$imgOrig,0,0,0,0,$anchoNew,$altoNew,$anchoOrig,$altoOrig);

        header("Content-type:image/$type");

        if(!is_dir("img/platos")):
            mkdir("img/platos");

        endif;

        $export = "image$type";
        $calidad = 75;

        $nombre_img= explode(' ', $nombre)[0];
        $nombre_img.= '_';
        $nombre_img.= explode(' ', $nombre)[1];

        $export($lienzoNew,"img/platos/$nombre_img.$type",$calidad);

        $rutaImagen = "img/platos/$nombre_img.$type";

    else:
        if(!empty($id)):
            $query=<<<IMG
            SELECT img
            FROM platos
            WHERE id=$id;
IMG;

            $imagen=Hacer_query($query, 'select', 1);
            $rutaImagen=$imagen['img'];

        else:
            $_SESSION['error']='img';
            header('Location:'. URL);
            die();

        endif;
    endif;

    $query='SELECT nombre, id FROM platos;';

    $aDatos=Hacer_query($query, 'select', 2);

    foreach($aDatos as $dato):
        if($nombre === $dato['nombre'] && $id !==  $dato['id']):
            $_SESSION['error']='nombre_existe';

            header('Location:'. URL);
            die();
            
        endif;
    endforeach;

    if(empty($id))://AGREGA PLATO
        foreach($_POST as $dato => $valor):
            if(!empty($dato) && $dato !== 'img'):
                $_SESSION['datos'][$dato]=$valor;
            
            endif;

        endforeach;

        $query="INSERT INTO platos (nombre, descripcion, img, tipo_id) VALUES ('$nombre','$descripcion','$rutaImagen',$tipo);";

        $rta=Hacer_query($query, 'insert', null);

        $ok='agregar_db';
        $error='agregar_db';
    
    else://EDITA PLATO
        $query="UPDATE platos SET nombre='$nombre', descripcion='$descripcion', img='$rutaImagen', tipo_id=$tipo WHERE id=$id;";

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