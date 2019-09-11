<?php
   if(!isset($_SESSION['user'])):
      $_SESSION['error']='denegado';

      header('Location: index.php?section=home');
      die();

   endif;

   if($aPedidos):
      $query=<<<ESTADO
         SELECT pedido, estado
         FROM pedidos_nro
         JOIN estados ON estados.id=pedidos_nro.estado_id
         GROUP BY pedido
ESTADO;
      $aEstados=Hacer_query($query, 'select', 2);

      foreach($aEstados as $estado):

        $_SESSION['checkout'][$estado['pedido']]['estado']=$estado['estado'];

      endforeach;

      $aPedidos=$_SESSION["checkout"];
      
   endif;
   
?>

<div id='carrito' class="encabezado">
   <h2>Mis pedidos</h2>
</div>

<section>
   <div class='<?= Class_msj() ?>'>
   <?php
      if(isset($_SESSION['ok'])):
         if($_SESSION['ok'] === 'checkout'):
            echo $aOks['checkout'];

         elseif($_SESSION['ok'] === 'eliminar_plato'):
            echo $aOks['eliminar_plato'];
            
         elseif($_SESSION['ok'] === 'anular'):
            echo $aOks['anular'];

         endif;
      
      elseif(isset($_SESSION['error'])):
         if($_SESSION['error'] === 'eliminar_plato'):
            echo $aErrores['eliminar_plato'];

         elseif($_SESSION['error'] === 'anular'):
            echo $aErrores['anular'];

         endif;

      endif;
   ?>
   </div>
   <div class="accordion" id="ver_pedidos">
      <div class="card text-center">
         <div class="card-header">
               <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="collapse" href="#pedido" role="button" aria-expanded="true" aria-controls="pedido">Pedidos</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="collapse" href="#seguimiento" role="button" aria-expanded="false" aria-controls="seguimiento">Seguimiento</a>
                  </li>
               </ul>
         </div>
         
         <div class="collapse show" id="pedido" data-parent="#ver_pedidos">
            <div class="card card-body">
            <?php
               if($aPlatos['total']):
            ?>
               
               <p>Total: $<?= $aPlatos['total'] ? $aPlatos['total'] : '0'?></p>

               <ul>
               <?php
                  foreach ($aPlatos as $plato):
                     if(is_array($plato)):
                        foreach($plato as $detalle):
               ?>
                  <li>
                     <form action="eliminar_plato.php" method="post">

                        <input type="hidden" name="plato" value='<?= array_search($plato, $aPlatos) ?>'>
                        <input type="hidden" name="precio" value='<?= $detalle['precio'] ?>'>

                        <button type="submit"><i class="fal fa-times-circle"></i></button>
                     </form>
                     <h3><?= $detalle['nombre']; ?> <span>$<?= $detalle['precio'] ?></span></h3>

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
               <a href="index.php?section=checkout">Finalizar pedido</a>
               <?php
               else:
               ?>
                  <p>No tienes ningún combo creado aún</p>

               <?php
               endif;
               ?>
            </div>
         </div>

         <div class="collapse" id="seguimiento" data-parent="#ver_pedidos">
            <div class="card card-body">
               <ul>
            <?php
               if($aPedidos):
                  foreach($aPedidos as $pedido):
            ?>
                  <li>
                  <?php
                     if($pedido['estado'] === 'Pendiente'):
                  ?>
                     <form action="anular_pedido.php" method="post">

                        <input type="hidden" name="pedido" value='<?= array_search($pedido, $aPedidos) ?>'>

                        <button type="submit"><i class="fas fa-ban"></i></button>
                     </form>
                  <?php
                     endif;
                  ?>
                     <h3><span> Pedido nro <?= array_search($pedido, $aPedidos) ?> </span> $<?= $pedido['total'] ?></h3>

                     <ul>
                        <li>Estado: <span><?= $pedido['estado'] ?></span></li>
                        <li>Detalle: 
                           <ul>
                  <?php
                        
                     foreach($pedido as $plato):
                        if(is_array($plato)):
                           foreach($plato as $detalle):
                  ?>

                           <li><i class="fas fa-circle"></i> <?= $detalle['nombre'] ?></li>

                  <?php
                           endforeach;
                        endif;
                     endforeach;
                  ?>       </ul>
                        </li>
                     </ul>
                     <a href="index.php?section=pedido_detalle&pedido=<?= array_search($pedido, $aPedidos) ?>">Más</a>
                     
                  </li>

            <?php
                  endforeach;
            ?>
                      
                  </ul>
            <?php

               else:
            ?>
               <p>No haz realizado un pedido aún o ya fue entregado/anulado</p>

            <?php
               endif;
            ?>
            </div>
         </div>
      </div>
   </div>
</section>
