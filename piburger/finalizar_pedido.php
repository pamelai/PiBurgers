<?php
   require_once('config/config.php');
   require_once('config/functions.php');

   define('URL', 'index.php?section=checkout');

   foreach($_POST as $dato => $valor):
      $aDatos[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));

      if(!empty($dato) && $dato !== 'nro_tar' && $dato !== 'cvv' && $dato !== 'clave' && $dato !== 'pass'):
         
         $_SESSION['datos'][$dato]=$valor;

      endif;

   endforeach;

   /* DOMICILIO */
   $domicilio=$aDatos['domicilio'];
   $tel=$aDatos['tel'];
   $calle=$aDatos['calle'];
   $nro=$aDatos['nro'];
   $ciudad=$aDatos['ciudad'];
   $prov=$aDatos['prov'];
   $tel_alter=$aDatos['tel_alter'];
   $guardar=$aDatos['guardar'] ? $aDatos['guardar'] : null;
   $guardar_tel=$aDatos['guardar_tel'] ? $aDatos['guardar_tel'] : null;

   /* PAGO */ 
   $tc=$aDatos['tc'];
   $metodo=$aDatos['metodo'];
   $titular=$aDatos['titular'];
   $nro_tar=$aDatos['nro_tar'];
   $vencimiento=$aDatos['vencimiento'];
   $cvv=$aDatos['cvv'];
   $guardar_tc=$aDatos['guardar_tc'] ? $aDatos['guardar_tc'] : null;

   $user=$aDatos['user'];
   $total=$aDatos['precio'];


   if(isset($domicilio) && empty($domicilio)):
      /* VERIFICACION DOMICILIO */
      $_SESSION['error']='domicilio';

      header ('Location:'.URL);
      die();

   elseif(!isset($domicilio) || $domicilio === 'otro'):
      if(empty($calle)):
         $_SESSION['error']='calle';

         header ('Location:'.URL);
         die();

      elseif(empty($nro)):
         $_SESSION['error']='nro';

         header ('Location:'.URL);
         die();

      elseif(empty($ciudad)):
         $_SESSION['error']='ciudad';

         header ('Location:'.URL);
         die();

      elseif(empty($prov)):
         $_SESSION['error']='prov';

         header ('Location:'.URL);
         die();

      elseif(($prov == 2 && $ciudad !== 4) || ($prov == 1 && $ciudad == 4)):
         $_SESSION['error']='prov_error';

         header ('Location:'.URL);
         die();

      endif;
   endif;

   if(isset($tel) && empty($tel)):
      /* VERIFICACION TELEFONO */
      $_SESSION['error']='tel_db';

      header ('Location:'.URL);
      die();

   elseif((!isset($tel) || $tel === 'otro') && empty($tel_alter)):
      $_SESSION['error']='tel_alter';

      header ('Location:'.URL);
      die();

   elseif(isset($tc) && empty($tc)):
      /* VERIFICACION PAGO */
      $_SESSION['error']='tc';
   
      header ('Location:'.URL);
      die();

   elseif(!isset($tc) || $tc === 'otro'):
      if(empty($metodo)):
         $_SESSION['error']='metodo';
   
         header ('Location:'.URL);
         die();

      elseif($metodo !== 'efectivo'):
         if(empty($titular)):
            $_SESSION['error']='titular';
   
            header ('Location:'.URL);
            die();

         elseif(empty($nro_tar)):
            $_SESSION['error']='nro_tar';
   
            header ('Location:'.URL);
            die();

         elseif(($metodo !== 6 && strlen($nro_tar) !== 16) || ($metodo == 6 && strlen($nro_tar) !== 19)):
            $_SESSION['error']='nro_tar_erroneo';
   
            header ('Location:'.URL);
            die();

         elseif(empty($vencimiento)):
            $_SESSION['error']='vencimiento';
   
            header ('Location:'.URL);
            die();

         elseif(empty($cvv)):
            $_SESSION['error']='cvv';
   
            header ('Location:'.URL);
            die();

         elseif($metodo === '4' && strlen($cvv) !== 4):
            $_SESSION['error']='cvv_american';
   
            header ('Location:'.URL);
            die();
            
         elseif($metodo !== '4' && strlen($cvv) !== 3):
            $_SESSION['error']='cvv_error';
   
            header ('Location:'.URL);
            die();

         endif;
      endif;
   endif;


   /* INSERT DOMICILIO */
   if($guardar):
      $query="INSERT INTO domicilios (calle, nro, prov_id, cd_id, usuario_id) VALUES ('$calle', $nro, $prov, $ciudad, $user)";

      $insert_domicilio=Hacer_query($query, 'insert', null);

      if(!$insert_domicilio):
         $_SESSION['error']='guardar_domicilio';

      endif;

   endif;

   /* INSERT TELEFONO */
   if($guardar_tel):
      $query="INSERT INTO telefonos (tel, usuario_id) VALUES ($tel_alter , $user)";

      $insert_tel=Hacer_query($query, 'insert', null);

      if(!$insert_tel):
         $_SESSION['error']='guardar_tel';

      endif;

   endif;

   $vencimiento.='-01';

   /* INSERT TC */
   if($guardar_tc && $metodo !== 'efectivo'):
      $query="INSERT INTO tarjetas (nro, vencimiento, titular, cvv, usuario_id, tipo_tarjeta_id) VALUES ($nro_tar, '$vencimiento', '$titular', $cvv, $user, $metodo)";

      $insert_tc=Hacer_query($query, 'insert', null);

      if(!$insert_tc):
         $_SESSION['error']='guardar_tc';

      endif;

   endif;
   
   $query=<<<PEDIDOS
         SELECT plato_nro
         FROM pedidos
         WHERE usuario_id=$user AND pedidos.plato_nro NOT IN (SELECT plato_nro FROM pedidos_nro)
PEDIDOS;

   $aPedidos=Hacer_query($query, 'select', 2);
  

   /* NRO PEDIDO */
   $cont=1;
   $query=<<<PEDIDO_NRO
         SELECT MAX(pedido) as pedido
         FROM pedidos_nro
PEDIDO_NRO;

   $ultimo_pedido=Hacer_query($query, 'select', 1);
   
   if($ultimo_pedido):
      $cont=$ultimo_pedido['pedido']+1;

   endif;

   if($metodo === 'efectivo'):
      $efectivo=1;

   else:
      $efectivo=0;

   endif;

   /* INSERTS */
   if(isset($domicilio) && $domicilio !== 'otro' && isset($tel) && $tel !== 'otro'):
      foreach($aPedidos as $pedido):
         $nro_pedido=$pedido['plato_nro'];
         
         $query="INSERT INTO pedidos_nro (usuario_id, pedido, plato_nro, estado_id, precio, domicilio_id, tel_id, efectivo) VALUES ($user, $cont, $nro_pedido, 1, $total, $domicilio, $tel, $efectivo);";

         $insert=Hacer_query($query, 'insert', null);

      endforeach;

   elseif(isset($domicilio) && $domicilio === 'otro' && isset($tel) && $tel !== 'otro'):
      foreach($aPedidos as $pedido):
         $nro_pedido=$pedido['plato_nro'];
         
         $query="INSERT INTO pedidos_nro (usuario_id, pedido, plato_nro, estado_id, precio, calle, nro, prov_id, cd_id, tel_id, efectivo) VALUES ($user, $cont, $nro_pedido, 1, $total, '$calle', $nro, $prov, $ciudad, $tel, $efectivo);";

         $insert=Hacer_query($query, 'insert', null);

      endforeach;

   elseif(isset($domicilio) && $domicilio !== 'otro' && isset($tel) && $tel === 'otro'):
      foreach($aPedidos as $pedido):
         $nro_pedido=$pedido['plato_nro'];
         
         $query="INSERT INTO pedidos_nro (usuario_id, pedido, plato_nro, estado_id, precio, domicilio_id, tel, efectivo) VALUES ($user, $cont, $nro_pedido, 1, $total, $domicilio, $tel_alter, $efectivo);";

         $insert=Hacer_query($query, 'insert', null);

      endforeach;

   else:
      foreach($aPedidos as $pedido):
         $nro_pedido=$pedido['plato_nro'];
         
         $query="INSERT INTO pedidos_nro (usuario_id, pedido, plato_nro, estado_id, precio, calle, nro, prov_id, cd_id, tel, efectivo) VALUES ($user, $cont, $nro_pedido, 1, $total, '$calle', $nro, $prov, $ciudad, $tel_alter, $efectivo);";

         $insert=Hacer_query($query, 'insert', null);

      endforeach;

   endif;

   if($insert):
      $_SESSION['checkout'][$cont]=$_SESSION['pedidos'];
      $_SESSION['checkout'][$cont]['estado']='Pendiente';
      unset($_SESSION['pedidos']);


      $_SESSION['ok']='checkout';
      header('Location:index.php?section=pedidos');
      unset($_SESSION['datos']);

   else:
      $_SESSION['error']='checkout';
      header('Location:'.URL);

   endif;