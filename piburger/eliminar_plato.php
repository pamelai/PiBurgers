<?php
   require_once('config/config.php');
   require_once('config/functions.php');

   define('URL', 'index.php?section=pedidos');

   $plato=mysqli_real_escape_string($conexion, $_POST['plato']);
   $precio=mysqli_real_escape_string($conexion, $_POST['precio']);

   $query="DELETE FROM pedidos WHERE plato_nro=$plato";

   $delete=Hacer_query($query, 'delete', null);

   if($delete):
      unset($_SESSION['pedidos'][$plato]);
      $_SESSION['pedidos']['total']-=$precio;

      $_SESSION['ok']='eliminar_plato';
      header('Location:'. URL);
      die();

   else:
      $_SESSION['error']='eliminar_plato';
      header('Location:'. URL);
      die();

   endif;