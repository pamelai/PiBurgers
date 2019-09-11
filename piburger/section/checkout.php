<?php
   if(!isset($_SESSION['user']) || !isset($aPlatos)):
      $_SESSION['error']='denegado';

      header('Location: index.php?section=home');
      die();

   endif;

   $query=<<<DOMICILIOS
         SELECT domicilios.id, calle, nro, cd
         FROM domicilios
         JOIN ciudades ON ciudades.id=domicilios.cd_id
         WHERE usuario_id=$user
         ORDER BY id;
DOMICILIOS;

   $aDomicilio=Hacer_query($query, 'select', 2);

   $query=<<<DOMICILIOS
         SELECT id, tel
         FROM telefonos
         WHERE usuario_id=$user
         ORDER BY id;
DOMICILIOS;

   $aTels=Hacer_query($query, 'select', 2);

   $query=<<<CIUDAD
         SELECT id, cd
         FROM ciudades
         ORDER BY ciudades.id;
CIUDAD;

   $aCd=Hacer_query($query, 'select', 2);

   $query=<<<PROVINCIAS
         SELECT id, prov
         FROM provincias
         ORDER BY id;
PROVINCIAS;

   $aProv=Hacer_query($query, 'select', 2);

   $query=<<<TIPOS_TC
         SELECT id, tipo
         FROM tipos_tarjetas
         ORDER BY id;
TIPOS_TC;

   $aMetodo=Hacer_query($query, 'select', 2);

   $query=<<<TC
      SELECT tarjetas.id, RIGHT(nro, 3) AS nro, tipo
      FROM tarjetas
      JOIN tipos_tarjetas ON tipos_tarjetas.id=tarjetas.tipo_tarjeta_id
      WHERE usuario_id=$user
      ORDER BY id;
TC;

   $aTc=Hacer_query($query, 'select', 2);
?>



<div id='checkout' class="encabezado">
    <h2>Checkout</h2>
</div>

<section >
   <p>Total a pagar $<?= $aPlatos['total'] ?></p>
   <div class='error'>
      <?= isset($_SESSION['error']) && $_SESSION['error']==='checkout' ? $aErrores['checkout'] : '';
         ?>
   </div>
   
   <form action="finalizar_pedido.php" method='post'>
      <fieldset>
         <legend>Domicilio de entrega</legend>
         
         <div id='fieldset'>
         <?php
            if($aDomicilio):
         ?>
            <div>
               <div>
                  <label>Mis direcciones</label>
                  <select name="domicilio" onchange="MetodoOtro(name, value)">

                     <?php
                        foreach($aDomicilio as $domicilio):

                     ?>
                     <option value="<?= $domicilio['id'] ?>" <?= isset($_SESSION['datos']['domicilio']) && $_SESSION['datos']['domicilio'] === $domicilio['id'] ? 'selected' : ''  ?> > <?= $domicilio['calle'].' '.$domicilio['nro'].', '.$domicilio['cd']?></option>

                     <?php
                        endforeach;
                     ?>
                     <option value="otro" <?= isset($_SESSION['datos']['domicilio']) && $_SESSION['datos']['domicilio'] === 'otro' ? 'selected' : ''  ?> >Otro</option>
                  
                  </select>
               </div>
         <?php
            endif;
         ?>

               <div id='otra_direc' >
                  <div>
                     <label>Calle</label>
                     <input type="text" name="calle" value='<?= isset($_SESSION['datos']['calle']) ? $_SESSION['datos']['calle'] : ''; ?>'>
                     <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='calle' ? $aErrores['calle'] : '';
                           ?>
                     </div>
                  </div>

                  <div>
                     <label>Altura</label>
                     <input type="number" name="nro" min='1' value='<?= isset($_SESSION['datos']['nro']) ? $_SESSION['datos']['nro'] : ''; ?>'>
                     <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='nro' ? $aErrores['nro'] : '';
                           ?>
                     </div>
                  </div>

                  <div>
                     <label>Ciudad</label>
                     <select name="ciudad">
                        <option value="" selected disabled>Seleccionar ciudad</option>

                        <?php
                           foreach($aCd as $ciud):
                        ?>

                           <option value="<?= $ciud['id'] ?>" <?= isset($_SESSION['datos']['ciudad']) && $_SESSION['datos']['ciudad'] === $ciud['id'] ? 'selected' : ''; ?> ><?= $ciud['cd'] ?></option>

                        <?php
                           endforeach;
                        ?>
                     
                     </select>
                     <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='ciudad' ? $aErrores['ciudad'] : '';
                           ?>
                     </div>
                  </div>

                  <div>
                     <label>Provincia</label>
                     <select name="prov">
                        <option value="" selected disabled>Seleccionar una provincia</option>

                        <?php
                           foreach($aProv as $prov):
                        ?>
                           <option value="<?= $prov['id'] ?>" <?= isset($_SESSION['datos']['prov']) && $_SESSION['datos']['prov'] === $prov['id'] ? 'selected' : ''; ?> ><?= $prov['prov'] ?></option>

                        <?php

                           endforeach;
                        ?>
                     
                     </select>
                     <div class='error'>
                        <?php
                              if( isset($_SESSION['error']) && $_SESSION['error']==='prov'):
                                 echo $aErrores['prov'];

                              elseif(isset($_SESSION['error']) && $_SESSION['error']==='prov_error'):
                                 echo $aErrores['prov_error'];

                              endif;
                           ?>
                     </div>
                  </div>

                  <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input" id="confir" name="guardar" value='si' <?= isset($_SESSION['datos']['guardar']) && $_SESSION['datos']['guardar'] === 'si' ? 'checked' : ''  ?>  >
                     <label class="custom-control-label" for="confir">Guardar dirección</label>
                  </div>
               </div>
            </div>
            <?php
               if($aTels):
            ?>
            <div>
               <div>
                  <label>Mis teléfonos</label>
                  <select name="tel" onchange="MetodoOtro(name, value)">

                     <?php
                        foreach($aTels as $tel):

                     ?>
                     <option value="<?= $tel['id'] ?>" <?= isset($_SESSION['datos']['tel']) && $_SESSION['datos']['tel'] === $tel['id'] ? 'selected' : ''  ?> ><?= $tel['tel']?></option>

                     <?php
                        endforeach;
                     ?>
                     <option value="otro" <?= isset($_SESSION['datos']['tel']) && $_SESSION['datos']['tel'] === 'otro' ? 'selected' : ''  ?> >Otro</option>
                  
                  </select>
               </div>

            <?php
               endif;
            ?>

               <div id='otro_tel'>
                  <div>
                     <label>Contacto</label>
                     <input type="number" name="tel_alter" value='<?= isset($_SESSION['datos']['tel_alter']) ? $_SESSION['datos']['tel_alter'] : ''; ?>'>
                     <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='tel_alter' ? $aErrores['tel_alter'] : '';
                           ?>
                     </div>
                  </div>

                  <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input" id="confir_tel" name="guardar_tel" value='si' <?= isset($_SESSION['datos']['guardar_tel']) && $_SESSION['datos']['guardar_tel'] === 'si' ? 'checked' : ''  ?> >
                     <label class="custom-control-label" for="confir_tel">Guardar teléfono</label>
                  </div>
               
               </div>
            </div>
         </div>
      </fieldset>

      <fieldset>
         <legend>Pago</legend>

         <?php
            if($aTc):
         ?>
            <div>
               <label>Mis tajetas</label>
               <select name="tc" onchange="MetodoOtro(name, value)">
                  <?php
                     foreach ($aTc as $tc):
                  ?>

                     <option value="<?= $tc['id'] ?>" <?= isset($_SESSION['datos']['tc']) && $_SESSION['datos']['tc'] === $tc['id'] ? 'checked' : ''  ?> ><?= $tc['tipo'].' terminada en '.$tc['nro'] ?></option>

                  <?php
                     endforeach;
                  ?>
                  <option value="otro" <?= isset($_SESSION['datos']['tc']) && $_SESSION['datos']['tc'] === 'otro' ? 'checked' : ''  ?> >Otro</option>
               
               </select>
            </div>
         <?php
            endif;
         ?>

         <div id='otro_metodo'>
            <div>
               <label>Método</label>
               <select name="metodo" onchange="MetodoOtro(name, value)">
                  <option value="" selected disabled>Seleccione método</option>
                  <option value="efectivo" <?= isset($_SESSION['datos']['metodo']) && $_SESSION['datos']['metodo'] === 'efectivo' ? 'checked' : ''  ?> >Efectivo</option>
                  <?php
                     foreach($aMetodo as $metodo):

                  ?>
                     <option value="<?= $metodo['id'] ?>" <?= isset($_SESSION['datos']['metodo']) && $_SESSION['datos']['metodo'] === $metodo['id'] ? 'selected' : ''  ?> ><?= $metodo['tipo'] ?></option>

                  <?php
                     endforeach;
                  ?>
               
               </select>
               <div class='error'>
                  <?= isset($_SESSION['error']) && $_SESSION['error']==='metodo' ? $aErrores['metodo'] : '';
                     ?>
               </div>
            </div>

            <div id='tarjeta'>
               <div>
                  <label>Titular</label>
                  <input type="text" name="titular" value='<?= isset($_SESSION['datos']['titular']) ? $_SESSION['datos']['titular'] : ''; ?>'>
                  <div class='error'>
                     <?= isset($_SESSION['error']) && $_SESSION['error']==='titular' ? $aErrores['titular'] : '';
                        ?>
                  </div>
               </div>

               <div>
                  <label>Nro. de tarjeta</label>
                  <input type="number" name="nro_tar" min='1' placeholder='Sin espacios ni guiones'>
                  <div class='error'>
                     <?php
                        if( isset($_SESSION['error']) && $_SESSION['error']==='nro_tar'):
                           echo $aErrores['nro_tar'];

                        elseif(isset($_SESSION['error']) && $_SESSION['error']==='nro_tar_erroneo'):
                           echo $aErrores['nro_tar_erroneo'];

                        endif;
                     ?>
                  </div>
               </div>

               <div>
                  <label>Fecha de vencimiento</label>
                  <input type="month" name="vencimiento">
                  <div class='error'>
                     <?= isset($_SESSION['error']) && $_SESSION['error']==='vencimiento' ? $aErrores['vencimiento'] : '';
                        ?>
                  </div>
               </div>

               <div>
                  <label>CVV</label>
                  <input type="number" name="cvv" min='1'>
                  <div class='error'>
                     <?php
                        if( isset($_SESSION['error']) && $_SESSION['error']==='cvv'):
                           echo $aErrores['cvv'];

                        elseif(isset($_SESSION['error']) && $_SESSION['error']==='cvv_american'):
                           echo $aErrores['cvv_american'];

                        elseif(isset($_SESSION['error']) && $_SESSION['error']==='cvv_error'):
                           echo $aErrores['cvv_error'];

                        endif;
                     ?>
                  </div>
               </div>

               <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="confir_tc" name="guardar_tc" value='si' <?= isset($_SESSION['datos']['guardar_tc']) && $_SESSION['datos']['guardar_tc'] === 'si' ? 'checked' : ''  ?> >
                  <label class="custom-control-label" for="confir_tc">Guardar tarjeta</label>
               </div>
            </div>
         </div>
      </fieldset>

      <input type="hidden" name="user" value='<?= $_SESSION['user']['id'] ?>'>
      <input type="hidden" name="precio" value='<?= $aPlatos['total'] ?>'>

      <input type="submit" value="Finalizar">
   </form>
</section>