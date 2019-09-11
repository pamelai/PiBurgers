<?php
    require_once("config/config.php");
    require_once("config/functions.php");

    foreach($_POST as $dato => $valor):
        $aDatosPost[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));
        
        if(!empty($dato) && $dato === 'comentario'):
            $_SESSION['datos'][$dato]=$valor;
        
        endif;

    endforeach;

    $plato=$aDatosPost['plato'];
    define('URL', "index.php?section=platos_detalle&id=$plato");


    $stars=$aDatosPost['stars'];
    $comentario=$aDatosPost['comentario'] ? $aDatosPost['comentario'] : null ;
    $id=$aDatosPost['id'];
    $plato=$aDatosPost['plato'];

    if(empty($stars)):
        $_SESSION['error']='stars';
        header('Location:'.URL);
        die();

    endif;

    $query="INSERT INTO comentarios (comentario, puntuacion, usuario_id, plato_id) VALUES";

    if($comentario === null):
        $query.="(null, $stars, $id, $plato);";

    else:
        $query.="('$comentario', $stars, $id, $plato);";

    endif;

    $insert=Hacer_query($query, 'insert', null);

    if($insert):
        $_SESSION['ok']='review';
        header('Location:'.URL);

        unset($_SESSION['datos']);

    else:
        $_SESSION['error']='review';
        header('Location:'.URL);

    endif;