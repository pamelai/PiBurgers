<?php
   if(empty($_GET['pedido']) || !$aPedidos[$_GET['pedido']]):
      header('Location:index.php?section=pedidos');
      die();

   else:
      $pedido=$_GET['pedido'];

   endif;


?>
<div id='pedido_detalle' class="encabezado">
   <h2>Detalle</h2>
</div>

<section class='info_pedido'>
   <ul>
   <?php
      foreach ($aPedidos[$pedido] as $plato):
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

   <a href="index.php?section=pedidos">Volver a Mis Pedidos</a>
</section>