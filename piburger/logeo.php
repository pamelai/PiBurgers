<?php
   require_once("config/config.php");
   require_once("config/functions.php");

   define('URL', 'index.php?section=login');

   if(empty($_POST['user'])):
      $_SESSION['error']='user_login';

      header('Location:'.URL);
      die();

   elseif(empty($_POST['pass'])):
      $_SESSION['error']='pass_login';

      header('Location:'.URL);
      die();

   endif;

   $user=mysqli_real_escape_string($conexion, htmlentities($_POST['user']));
   $pass=mysqli_real_escape_string($conexion, htmlentities($_POST['pass']));

   if(strpos($user,"@")):
      $col='email';
   
   else:
      $col='usuario';

   endif;

   $query= <<<USER
      SELECT * 
      FROM usuarios
      WHERE $col='$user';
USER;

   $aUser=Hacer_query($query, 'select', 1);
   
   if(!password_verify($pass, $aUser['pass'])):
      $_SESSION['error']='user_incorrecto';

      header('Location:'.URL);
      die();

   endif;

   $_SESSION['user']=$aUser;

   $id=$aUser['id'];
   $_SESSION['pedidos']=[];
   $query=<<<PLATOS
         SELECT plato_nro, precio
         FROM pedidos
         WHERE pedidos.usuario_id=$id AND pedidos.plato_nro NOT IN (SELECT plato_nro FROM pedidos_nro GROUP BY plato_nro)
         GROUP BY pedidos.plato_nro;
PLATOS;

   $aPlatos=Hacer_query($query, 'select', 2);

   foreach ($aPlatos as $plato):
      $plato_nro=$plato['plato_nro'];
      $total=$plato['precio'];
      $total_final+=$plato['precio'];
      
      $query=<<<PEDIDOS
         SELECT nombre, tipo, cantidad
         FROM pedidos
         JOIN platos ON platos.id=pedidos.plato_id
         LEFT JOIN tipos_hamburguesas ON tipos_hamburguesas.id=pedidos.tipo_hamburguesa_id
         WHERE plato_nro=$plato_nro
         GROUP BY nombre;
PEDIDOS;

      $detalle=Hacer_query($query, 'select', 1);

      $query=<<<ADICIONALES
         SELECT adicional, tipo
         FROM pedidos
         LEFT JOIN adicionales AS adicion ON adicion.id=pedidos.adicionales_id
         JOIN tipos ON tipos.id=adicion.tipo_id
         WHERE plato_nro=$plato_nro
ADICIONALES;

      $aAdicionales=Hacer_query($query, 'select', 2);

      if($aAdicionales):
         $aCombos['topins']=[];
         foreach($aAdicionales as $adicional):

            if($adicional['tipo'] === 'Grilled HotDogs'):
               $aCombos['topins']=$adicional['adicional'];
            
            elseif($adicional['tipo'] === 'Burgers'):
               array_push($aCombos['topins'], $adicional['adicional']);

            elseif($adicional['tipo'] === 'Drinks'):
               $aCombos['bebida']=$adicional['adicional'];
            
            elseif($adicional['tipo'] === 'Fries'):
               $aCombos['papas']=$adicional['adicional'];

            endif;

         endforeach;
      endif;

      $pedido=[];
      $pedido['nombre']=$detalle['nombre'];
      if($detalle['tipo']):
         $pedido['tipo']=$detalle['tipo'];

      endif;
      if($aAdicionales):
         $pedido['adicionales']=$aCombos;

      endif;
      $pedido['precio']=$total;
      $pedido['cant']=$detalle['cantidad'];

      $_SESSION['pedidos'][$plato_nro]=[];
      array_push($_SESSION['pedidos'][$plato_nro], $pedido);
   endforeach;
   $_SESSION['pedidos']['total']=$total_final;


   $query=<<<CHECOUT
      SELECT pedido, plato_nro, precio, estado
      FROM pedidos_nro
      JOIN estados ON estados.id=pedidos_nro.estado_id
      WHERE usuario_id=$id
      GROUP BY plato_nro;
CHECOUT;

   $aCheckout=Hacer_query($query, 'select', 2);

   foreach ($aCheckout as $plato):
      $plato_nro=$plato['plato_nro'];
      $nro_pedido=$plato['pedido'];
      $total=$plato['precio'];
      $estado=$plato['estado'];
      
      $query=<<<PEDIDOS
         SELECT nombre, tipo, cantidad, pedidos.precio
         FROM pedidos
         JOIN platos ON platos.id=pedidos.plato_id
         LEFT JOIN tipos_hamburguesas ON tipos_hamburguesas.id=pedidos.tipo_hamburguesa_id
         WHERE plato_nro=$plato_nro
         GROUP BY nombre;
PEDIDOS;

      $detalle=Hacer_query($query, 'select', 1);

      $query=<<<ADICIONALES
         SELECT adicional, tipo
         FROM pedidos
         LEFT JOIN adicionales AS adicion ON adicion.id=pedidos.adicionales_id
         JOIN tipos ON tipos.id=adicion.tipo_id
         WHERE plato_nro=$plato_nro
ADICIONALES;

      $aAdicionales=Hacer_query($query, 'select', 2);

      if($aAdicionales):
         $aCombos['topins']=[];
         foreach($aAdicionales as $adicional):

            if($adicional['tipo'] === 'Grilled HotDogs'):
               $aCombos['topins']=$adicional['adicional'];
            
            elseif($adicional['tipo'] === 'Burgers'):
               array_push($aCombos['topins'], $adicional['adicional']);

            elseif($adicional['tipo'] === 'Drinks'):
               $aCombos['bebida']=$adicional['adicional'];
            
            elseif($adicional['tipo'] === 'Fries'):
               $aCombos['papas']=$adicional['adicional'];

            endif;

         endforeach;
      endif;

      $pedido=[];
      $pedido['nombre']=$detalle['nombre'];
      if($detalle['tipo']):
         $pedido['tipo']=$detalle['tipo'];

      endif;
      if($aAdicionales):
         $pedido['adicionales']=$aCombos;

      endif;
      $pedido['precio']=$detalle['precio'];
      $pedido['cant']=$detalle['cantidad'];

      $aPedidos[$plato_nro]=[];
      array_push($aPedidos[$plato_nro], $pedido);

      $_SESSION['checkout'][$nro_pedido]=$aPedidos;
      $_SESSION['checkout'][$nro_pedido]['total']=$total;
      $_SESSION['checkout'][$nro_pedido]['estado']=$estado;
   endforeach;


   if($aUser['rol_id'] != 2 ):
      header("Location:panel.php?seccion=lista_panel");
      die();
   
   else:
      header("Location:index.php");
      die();

   endif;
