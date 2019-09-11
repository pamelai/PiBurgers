<?php
   $pedido_nro=$_GET['pedido'];

   $query=<<<PLATOS
   SELECT pedido, plato_nro, precio, estado
   FROM pedidos_nro
   JOIN estados ON estados.id=pedidos_nro.estado_id
   WHERE pedido=$pedido_nro
   GROUP BY plato_nro;
PLATOS;

   $aCheckout=Hacer_query($query, 'select', 2);

   if(!$aCheckout):
      header('Location: panel.php?section=lista_panel');
      die();

  endif;

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

      $aPedido[$nro_pedido]=$aPedidos;
      $aPedido[$nro_pedido]['total']=$total;
      $aPedido[$nro_pedido]['estado']=$estado;
   endforeach;


?>
<section class='info_pedido' id='info_pedido_panel'>
<ul>
   <?php
      foreach ($aPedido[$pedido_nro] as $plato):
         
         if(is_array($plato)):
            foreach($plato as $detalle):
   ?>
      <li>
         <h3><?= $detalle['cant'] > 1 ? $detalle['nombre'].' x'.$detalle['cant'] : $detalle['nombre']; ?> <span>$<?= $detalle['precio'] ?></span></h3>

         <ul>
            <?php
               if(@$detalle['tipo']): 
            ?>
               <li>Tipo: <span><?= $detalle['tipo'] ?></span></li>

            <?php
               endif;
               if(@$detalle['adicionales']):
                  if($detalle['adicionales']['topins']):
            ?>
               <li>Adicionales: 
                  <ul>
                  <?php
                     if(is_array($detalle['adicionales']['topins'])):
                        foreach($detalle['adicionales']['topins'] as $topins):
                        
                  ?>
                        <li><i class="fas fa-circle"></i> <?= $topins ?></li> 
                  
                  <?php
                        endforeach;
                     else:
                  ?>
                     <li><i class="fas fa-circle"></i> <?= $detalle['adicionales']['topins'] ?></li> 

                  <?php
                     endif;
                  ?>
                  </ul>
               </li>
            <?php
                     
                  endif;
                  if(@$detalle['adicionales']['bebida']):
            ?>
                  <li>Bebida: <span><?= $detalle['adicionales']['bebida'] ?></span></li>
            <?php

                  endif;
                  if(@$detalle['adicionales']['papas']):
            ?>
                  <li>Papas: <span><?= $detalle['adicionales']['papas'] ?></span></li>
            <?php

                  endif;
               endif;
            ?>
         </ul>
      </li>
   <?php
            endforeach;
         endif;
      endforeach;
   ?>
   </ul>

   <a href="panel.php?section=lista_panel">Volver al panel</a>
</section>