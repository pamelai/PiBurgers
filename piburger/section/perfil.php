<?php
   if(!isset($_SESSION['user'])):
      $_SESSION['error']='denegado';

      header('Location: index.php?section=home');
      die();

   endif;

   $query=<<<TARJETAS
      SELECT tarjetas.id, titular, tipo, RIGHT(nro, 3) AS nro, LEFT(vencimiento, 7) AS vencimiento
      FROM tarjetas
      JOIN tipos_tarjetas ON tipos_tarjetas.id=tarjetas.tipo_tarjeta_id
      WHERE usuario_id=$user;
TARJETAS;

   $aTc=Hacer_query($query, 'select', 2);

   $query=<<<TARJETAS
      SELECT domicilios.id, calle, nro, cd, prov
      FROM domicilios
      JOIN provincias ON provincias.id=domicilios.prov_id
      JOIN ciudades ON ciudades.id=domicilios.cd_id
      WHERE usuario_id=$user;
TARJETAS;

   $aDirec=Hacer_query($query, 'select', 2);

   $query=<<<TARJETAS
      SELECT tel, id
      FROM telefonos
      WHERE usuario_id=$user;
TARJETAS;

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
   
?>
<div id='perfil' class="encabezado">
   <h2>Perfil</h2>
</div>

<section>
   <h3>Datos de cuenta</h3>

   <div class='<?= Class_msj() ?>'>
      <?php
         if(isset($_SESSION['ok'])):
               echo $aOks['update_db'];

         elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'update_db'):
               echo $aErrores['update_db'];

         endif;
      ?>
   </div>
   
   
   <form action="editar_datos.php" method='post' enctype='multipart/form-data' id='datos'>
      <label for="img">
            <figure>
               <img src="<?= $_SESSION['user']['img'] ?>" alt="<?= $_SESSION['user']['usuario'] ?>">
            </figure>

            <input type="file" name="img" id="img" accept='image/png, image/jpeg'>
      </label>
   </form>

   <div>
      <h4>Datos personales</h4>

      <button type='button' class='abrir_form'>Editar datos</button>
      <ul>
         <li><span>Nombre:</span> <?= isset($_SESSION['user']['nombre']) ? $_SESSION['user']['nombre'] : 'Sin especificar' ?></li>
         
         <li><span>Apellido:</span> <?= isset($_SESSION['user']['apellido']) ? $_SESSION['user']['apellido'] : 'Sin especificar' ?></li>
         <li><span>Usuario</span>: <?= $_SESSION['user']['usuario']?></li>
         <li><span>Contraseña:</span> ********</li>
         <li><span>E-mail:</span> <?= $_SESSION['user']['email'] ?></li>
      </ul>
   </div>

   
   <div id='editar_datos'>
      <div>
         <label>Nombre</label>
         <input type="text" name="nombre" value='<?= isset($_SESSION['user']['nombre']) ? ucfirst($_SESSION['user']['nombre']) : '' ?>' form='datos'>
      </div>

      <div>
         <label>Apellido</label>
         <input type="text" name="apellido" value='<?= isset($_SESSION['user']['apellido']) ? ucfirst($_SESSION['user']['apellido']) : '' ?>' form='datos'>
      </div>

      <div>
         <label>Usuario</label>
         <input type="text" name="usuario" value='<?= isset($_SESSION['user']['usuario']) ? $_SESSION['user']['usuario'] : '' ?>' form='datos'>
      </div>

      <div>
         <label>Contraseña</label>
         <input type="password" name="pass" placeholder='******' form='datos'>
      </div>

      <div>
         <label>E-mail</label>
         <input type="email" name="email" value='<?= isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '' ?>' form='datos'>
      </div>


      <input type="hidden" name="id" value='<?= $user ?>' form='datos'>

      <div class='botones_forms'>
         <input type="submit" value="Guardar cambios" form='datos'>
         <button type='button' class='cerrar'>Cerrar</button>
      </div>
   </div>

   <div>
      <h4>Medios de pago</h4>
      <button type='button' class='abrir_form'>Agregar</button>
   <?php 
      if($aTc):
   ?>
      <ul>
      <?php
         foreach($aTc as $tc):
      ?>
      
         <li>
         <?= ucfirst($tc['titular']) ?> <span id='dato_tc'><?= $tc['tipo'].' terminada en '. $tc['nro'] ?></span> Vto. <?= $tc['vencimiento'] ?>  
         <button type="submit" name='borrar_tc' value='<?= $tc['id'] ?>' form='datos'><i class="fal fa-times-circle"></i></button>
         
         </li>

      <?php
         endforeach;
      ?>
      </ul>
   <?php
      else:
   ?>
      <p>No tienes ningún medio de pago registrado</p>
   <?php
      endif;
   ?>
   </div>

   <div id='medio_pago' style='<?= isset($_SESSION['datos']['metodo']) || isset($_SESSION['error']) && $_SESSION['error'] === 'metodo'? 'display:block': ''; ?>'>

      <div>
         <label>Método</label>
         <select name="metodo" onchange="Metodo(name, value)" form='datos'>
            <option value="" selected disabled>Seleccione método</option>
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

      <div>
         <label>Titular</label>
         <input type="text" name="titular" value='<?= isset($_SESSION['datos']['titular']) ? $_SESSION['datos']['titular'] : ''; ?>' form='datos' form='datos'>
         <div class='error'>
            <?= isset($_SESSION['error']) && $_SESSION['error']==='titular' ? $aErrores['titular'] : '';
               ?>
         </div>
      </div>

      <div>
         <label>Nro. de tarjeta</label>
         <input type="number" name="nro_tar" min='1' placeholder='Sin espacios ni guiones' form='datos'>
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
         <input type="month" name="vencimiento" form='datos'>
         <div class='error'>
            <?= isset($_SESSION['error']) && $_SESSION['error']==='vencimiento' ? $aErrores['vencimiento'] : '';
               ?>
         </div>
      </div>

      <div>
         <label>CVV</label>
         <input type="number" name="cvv" min='1' form='datos'>
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

      <input type="hidden" name="id" value='<?= $user ?>' form='datos'>
   
      <div class='botones_forms'>
         <input type="submit" value="Guardar datos" form='datos'>
         <button type='button' class='cerrar'>Cerrar</button>
      </div>
   </div>

   <div>
      <h4>Direcciones</h4>
      <button type='button' class='abrir_form'>Agregar</button>
   <?php 
      if($aDirec):
   ?>
      <ul>
      <?php
         foreach($aDirec as $direc):
      ?>
      
         <li>
         <?= ucfirst($direc['calle']).' '.$direc['nro'].', '.ucfirst($direc['cd']).', '.ucfirst($direc['prov'])?>  <button type="submit" name='borrar_direc' value='<?= $direc['id'] ?>' form='datos'><i class="fal fa-times-circle"></i></button>
         
         </li>

      <?php
         endforeach;
      ?>
      </ul>
   <?php
      else:
   ?>
      <p>No tienes ninguna dirección registrada</p>
   <?php
      endif;
   ?>
   </div>

   <div id='direc' style='<?= isset($_SESSION['datos']['calle']) || isset($_SESSION['error']) && $_SESSION['error'] === 'calle'? 'display:block': ''; ?>'>

      <div>
         <label>Calle</label>
         <input type="text" name="calle" value='<?= isset($_SESSION['datos']['calle']) ? $_SESSION['datos']['calle'] : ''; ?>' form='datos'>
         <div class='error'>
            <?= isset($_SESSION['error']) && $_SESSION['error']==='calle' ? $aErrores['calle'] : '';
               ?>
         </div>
      </div>

      <div>
         <label>Altura</label>
         <input type="number" name="nro" min='1' value='<?= isset($_SESSION['datos']['nro']) ? $_SESSION['datos']['nro'] : ''; ?>' form='datos'>
         <div class='error'>
            <?= isset($_SESSION['error']) && $_SESSION['error']==='nro' ? $aErrores['nro'] : '';
               ?>
         </div>
      </div>

      <div>
         <label>Ciudad</label>
         <select name="ciudad" form='datos'>
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
         <select name="prov" form='datos'>
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
      <input type="hidden" name="id" value='<?= $user ?>' form='datos'>
   
      <div class='botones_forms'>
         <input type="submit" value="Guardar datos" form='datos'>
         <button type='button' class='cerrar'>Cerrar</button>
      </div>
   </div>

   <div>
      <h4>Teléfonos</h4>
      <button type='button' class='abrir_form'>Agregar</button>
   <?php 
      if($aTels):
   ?>
      <ul>
      <?php
         foreach($aTels as $tel):
      ?>
      
         <li>
         <?= $tel['tel']?>  <button type="submit" name='borrar_tel' value='<?= $tel['id'] ?>' form='datos'><i class="fal fa-times-circle"></i></button>
         
         </li>

      <?php
         endforeach;
      ?>
      </ul>
   <?php
      else:
   ?>
      <p>No tienes ningún teléfono registrado</p>
   <?php
      endif;
   ?>
   </div>
   
   <div id='tel' style='<?= isset($_SESSION['datos']['tel_alter']) || isset($_SESSION['error']) && $_SESSION['error'] === 'tel_db'? 'display:block': ''; ?>'>

      <div>
         <label>Contacto</label>
         <input type="number" name="tel" value='<?= isset($_SESSION['datos']['tel_alter']) ? $_SESSION['datos']['tel_alter'] : ''; ?>' form='datos'>
         <div class='error'>
            <?= isset($_SESSION['error']) && $_SESSION['error']==='tel_db' ? $aErrores['tel_alter'] : '';
               ?>
         </div>
      </div>
      
      <input type="hidden" name="id" value='<?= $user ?>' form='datos'>
   
      <div class='botones_forms'>
         <input type="submit" value="Guardar datos" form='datos'>
         <button type='button' class='cerrar'>Cerrar</button>
      </div>
   </div>
</section>