<?php
   require_once('config/config.php');
   require_once('config/functions.php');
   define('URL', 'index.php?section=pedidos');

   $pedido=mysqli_real_escape_string($conexion, $_POST['pedido']);
   
   $query="DELETE FROM pedidos_nro WHERE pedido=$pedido;";

   $delete=Hacer_query($query, 'delete', null);

   if($delete):
      $_SESSION['pedidos']=$_SESSION['checkout'][$pedido];
      unset( $_SESSION['checkout'][$pedido]);

      $_SESSION['ok']='anular';
      header('Location:'.URL);

   else:
      $_SESSION['error']='anular';
      header('Location:'.URL);

   endif;