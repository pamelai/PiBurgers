<?php
    require_once("config/config.php");

    define('URL', 'index.php?section=contacto');

    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $email=$_POST['email'];
    $motivo1=$_POST['motivo1'];
    $motivo2=$_POST['motivo2'];
    $motivo3=$_POST['motivo3'];
    $motivo4=$_POST['motivo4'];
    $coment=$_POST['comentario'];

    foreach($_POST as $dato => $valor):
        if(!empty($dato)):
           $_SESSION['datos'][$dato]=$valor;
  
        endif;

    endforeach;

    if(empty($email)):
        $_SESSION['error']='email';

        header ("Location:".URL);
        die();

    elseif(empty($motivo1) && empty($motivo2) && empty($motivo3) && empty($motivo4)):
        $_SESSION['error']='motivo';

        header ("Location:".URL);
        die();

    elseif(empty($coment)):
        $_SESSION['error']='comentario';

        header ("Location:".URL);
        die();

    endif;

    $_SESSION['ok']='enviado';
    header ('Location:'.URL);
    
    unset($_SESSION['datos']);  