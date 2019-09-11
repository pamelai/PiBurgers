<?php
   require_once('config/config.php');
   require_once('config/functions.php');
   define('URL', 'panel.php?section=lista_panel');

   $estado=mysqli_real_escape_string($conexion, $_POST['estado']);
   $pedido=mysqli_real_escape_string($conexion, $_POST['pedido']);

   $query="UPDATE pedidos_nro SET estado_id=$estado WHERE pedido=$pedido;";

   $update=Hacer_query($query, 'update', null);

   if($update):
      $_SESSION['ok']='estado';
      header('Location:'.URL);

   else:
      $_SESSION['error']='estado';
      header('Location:'.URL);

   endif;