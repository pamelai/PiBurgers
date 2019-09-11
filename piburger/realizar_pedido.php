<?php
   require_once('config/config.php');
   require_once('config/functions.php');
   require_once('config/arrays.php');

   define('URL', 'index.php?section=hacer_pedido');

   
   foreach($_POST as $dato => $valor):
      $aDatos[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));

      if(!empty($dato)):
          $_SESSION['datos'][$dato]=$valor;
      
      endif;

   endforeach;

   $burger=$aDatos['burger'] ? $aDatos['burger'] : null;
   $hotdog=$aDatos['hotdog'] ? $aDatos['hotdog'] : null;
   $tipo=$aDatos['tipo'] ? $aDatos['tipo'] : null;
   $adicional1=$aDatos['adicional1'] ? $aDatos['adicional1'] : null;
   $adicional2=$aDatos['adicional2'] ? $aDatos['adicional2'] : null;
   $adicional3=$aDatos['adicional3'] ? $aDatos['adicional3'] : null;
   $adicional4=$aDatos['adicional4'] ? $aDatos['adicional4'] : null;
   $adicional5=$aDatos['adicional5'] ? $aDatos['adicional5'] : null;
   $adicional6=$aDatos['adicional6'] ? $aDatos['adicional6'] : null;
   $papas_pay=$aDatos['papas_pay'] ? $aDatos['papas_pay'] : null;
   $fries=$aDatos['fries'] ? $aDatos['fries'] : null;
   $bebida=$aDatos['bebida'] ? $aDatos['bebida'] : null;
   $user=$aDatos['user'];
   $cant=$aDatos['cant'];


   if(empty($burger) && empty($hotdog)):
      $_SESSION['error']='plato_vacio';
      header('Location:'. URL);
      die();

  elseif(!empty($burger) && !empty($hotdog)):
      $_SESSION['error']='plato_doble';
      header('Location:'. URL);
      die();

  elseif(!empty($burger) && empty($tipo)):
      $_SESSION['error']='tipo';
      header('Location:'. URL);
      die();

  elseif(!empty($burger) && !empty($papas_pay)):
      $_SESSION['error']='adicional';
      header('Location:'. URL);
      die();

  elseif(!empty($hotdog) && (!empty($adicional1) || !empty($adicional2) || !empty($adicional3) || !empty($adicional4) || !empty($adicional5) || !empty($adicional6)) ):
      $_SESSION['error']='adicional';
      header('Location:'. URL);
      die();

  elseif(isset($cant) && empty($cant)):
      $_SESSION['error']='cant';
      header('Location:'. URL);
      die();

  endif;


 /* ADICIONALES */
  $aAdicionales=[];
  foreach($aDatos as $dato => $valor):
      if(!empty($dato) && ($dato === 'adicional1' || $dato === 'adicional2' || $dato === 'adicional3' || $dato === 'adicional4' || $dato === 'adicional5' || $dato === 'adicional6' || $dato === 'bebida' || $dato === 'fries' || $dato === 'papas_pay')):
         $aAdicionales[$dato]=$valor;

      endif;

   endforeach;

  /* VALOR TOTAL DEL PLATO */
  if($burger != null):
      $query=<<<PRECIO_BURGER
            SELECT precio 
            FROM platos
            WHERE id=$burger;
PRECIO_BURGER;

      $precio_burger=Hacer_query($query, 'select', 1);
      $precio_total=$precio_burger['precio'];


      $query=<<<TIPO_BURGER
            SELECT precio 
            FROM tipos_hamburguesas
            WHERE id=$tipo;

TIPO_BURGER;

      $precio_tipo=Hacer_query($query, 'select', 1);
      $precio_total+=$precio_tipo['precio'];

   elseif($hotdog != null):
      $query=<<<PRECIO_HOTDOG
         SELECT precio 
         FROM platos
         WHERE id=$hotdog;
PRECIO_HOTDOG;

      $precio_hotdog=Hacer_query($query, 'select', 1);
      $precio_total=$precio_hotdog['precio'];

   endif;

   foreach($aAdicionales as $adicional => $id):
      $query=<<<PRECIO_ADICIONAL
            SELECT precio
            FROM adicionales
            WHERE id=$id;
PRECIO_ADICIONAL;

      $precio_adicional=Hacer_query($query, 'select', 1);
      $precio_total+=$precio_adicional['precio'];
   endforeach;

   $precio_total*=$cant;


   /* NRO DE PLATO*/ 
   $cont=1;
   $query=<<<PLATO_NRO
         SELECT MAX(plato_nro) as plato_nro
         FROM pedidos
PLATO_NRO;

   $ultimo_plato=Hacer_query($query, 'select', 1);
   
   if($ultimo_plato):
      $cont=$ultimo_plato['plato_nro']+1;

   endif;


   /* INSERTS */ 
   if(count($aAdicionales) !== 0):
      foreach($aAdicionales as $adicional => $id):
            $query="INSERT INTO pedidos (plato_nro,usuario_id, plato_id, tipo_hamburguesa_id, adicionales_id, cantidad, precio) VALUES ($cont, $user, ";

            if($burger == null):
               $query.="$hotdog, null, $id, ";

            elseif($hotdog == null):
               $query.="$burger, $tipo, $id, ";

            endif;

            $query.="$cant, $precio_total);";

            $insert=Hacer_query($query, 'insert', null);
      endforeach;

   else:
      $query="INSERT INTO pedidos (plato_nro, usuario_id, plato_id, tipo_hamburguesa_id, adicionales_id, cantidad, precio) VALUES ($cont, $user, ";

      if($burger === null):
            $query.="$hotdog, null, null, ";

      elseif($hotdog === null):
            $query.="$burger, $tipo, null, ";

      endif;

      $query.="$cant, $precio_total);";

      $insert=Hacer_query($query, 'insert', null);

   endif;


   if($insert):

      $query=<<<PLATOS
            SELECT plato_nro, precio
            FROM pedidos
            WHERE pedidos.usuario_id=$user AND pedidos.plato_nro=$cont
            GROUP BY pedidos.plato_nro;
PLATOS;

      $aPlatos=Hacer_query($query, 'select', 2);

      foreach ($aPlatos as $plato):
         
         $query=<<<PEDIDOS
            SELECT nombre, tipo, cantidad
            FROM pedidos
            JOIN platos ON platos.id=pedidos.plato_id
            LEFT JOIN tipos_hamburguesas ON tipos_hamburguesas.id=pedidos.tipo_hamburguesa_id
            WHERE plato_nro=$cont
            GROUP BY nombre;
PEDIDOS;

         $detalle=Hacer_query($query, 'select', 1);

         $query=<<<ADICIONALES
            SELECT adicional, tipo
            FROM pedidos
            LEFT JOIN adicionales AS adicion ON adicion.id=pedidos.adicionales_id
            JOIN tipos ON tipos.id=adicion.tipo_id
            WHERE plato_nro=$cont
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
         $pedido['precio']=$precio_total;
         $pedido['cant']=$detalle['cantidad'];

         $_SESSION['pedidos'][$cont]=[];
         array_push($_SESSION['pedidos'][$cont], $pedido);
      endforeach;
      $_SESSION['pedidos']['total']+=$precio_total;


      $_SESSION['ok']='pedido';
      header('Location:'.URL);
      unset($_SESSION['datos']);

   else:
      $_SESSION['error']='pedido';
      header('Location:'.URL);

   endif;