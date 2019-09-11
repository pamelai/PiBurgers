<?php
   require_once("config/config.php");
   require_once("config/functions.php");

   define('URL', 'panel.php?seccion=usuarios');

   $user_id=mysqli_real_escape_string($conexion, $_POST['user_id']);
   $plato_id=mysqli_real_escape_string($conexion, $_POST['plato_id']);
   $adic_id=mysqli_real_escape_string($conexion, $_POST['adic_id']);

   if(isset($user_id) && !empty($user_id)):
      $query="DELETE FROM usuarios WHERE id=$user_id;";

      $delete=Hacer_query($query, 'delete', null);

   elseif(isset($plato_id) && !empty($plato_id)):
      $query="DELETE FROM platos WHERE id=$plato_id;";

      $delete=Hacer_query($query, 'delete', null);

   elseif(isset($adic_id) && !empty($adic_id)):
      $query="DELETE FROM adicionales WHERE id=$adic_id;";

      $delete=Hacer_query($query, 'delete', null);

   else:
      $_SESSION['error']='eliminar';
      header('Location:'.URL);

   endif;
   /*  echo $query;
    echo mysqli_error($conexion);
    die(); */

   if($delete):
      $_SESSION['ok']='eliminar';
      header('Location:'.URL);

   else:
      $_SESSION['error']='eliminar';
      header('Location:'.URL);

   endif;
   