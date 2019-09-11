<?php
    require_once('config/config.php');
    require_once('config/functions.php');
    require_once('config/arrays.php');

    foreach($_POST as $dato => $valor):
           $aDatosPost[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));
           
    endforeach;

    $nombre=$aDatosPost['nombre'];
    $tipo=$aDatosPost['tipo'];
    $id=$aDatosPost['id'];
    $precio=$aDatosPost['precio'];

    if(empty($id)):
        define('URL', 'panel.php?section=form_adicional');

    else:  
        define('URL', "panel.php?section=form_adicional&adicional=$id");

    endif;

    if(isset($nombre) && empty($nombre)):
        $_SESSION['error']='adicional';
        header('Location:'. URL);
        die();

    elseif(isset($tipo) && empty($tipo)):
        $_SESSION['error']='tipo';
        header('Location:'. URL);
        die();

    elseif(isset($precio) && empty($precio)):
        $_SESSION['error']='precio';
        header('Location:'. URL);
        die();

    endif;

    $query='SELECT adicional, id FROM adicionales;';

    $aDatos=Hacer_query($query, 'select', 2);

    foreach($aDatos as $dato):
        if($nombre === $dato['adicional'] && $id !==  $dato['id']):
            $_SESSION['error']='adicional_existe';

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

      $query="INSERT INTO adicionales (adicional, tipo_id, precio) VALUES ('$nombre', $tipo, $precio);";

      $rta=Hacer_query($query, 'insert', null);

      $ok='agregar_db';
      $error='agregar_db';
  
  else://EDITA PLATO
      $query="UPDATE adicionales SET adicional='$nombre', tipo_id=$tipo, precio=$precio WHERE id=$id;";

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