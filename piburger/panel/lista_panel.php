<?php
   $rol=$_SESSION['user']['rol_id'];

   $query=<<<USUARIOS
      SELECT usuarios.id, IFNULL(nombre,'Sin especificar') as nombre, IFNULL(apellido,'Sin especificar') as apellido, usuario, email, rol
      FROM usuarios
      JOIN roles ON usuarios.rol_id=roles.id
      ORDER BY usuarios.id;
USUARIOS;

   $rta=mysqli_query($conexion, $query);

?>
<section id='lista'>
   <div class='<?= Class_msj() ?>'>
      <?php
         if(isset($_SESSION['ok'])):
            
            if($_SESSION['ok']=== 'eliminar'):
               echo $aOks['eliminar'];

            elseif($_SESSION['ok']=== 'update_db'):
               echo $aOks['update_db'];

            elseif($_SESSION['ok']=== 'agregar_db'):
               echo $aOks['agregar_db'];

            elseif($_SESSION['ok']=== 'estado'):
               echo $aOks['estado'];

            endif;

         elseif(isset($_SESSION['error'])):
            
               if($_SESSION['error']=== 'eliminar'):
                  echo $aErrores['eliminar'];

               elseif($_SESSION['error']=== 'estado'):
                  echo $aErrores['estado'];

               endif;

         endif;
      ?>
   </div>

   <div class="accordion" id="panel_lista">
   <?php
      if($rol !=3):

   ?>
      <div class="card">
         <div class="card-header" id="usuarios">
            <h2 class="mb-0">
               <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Listado de usuarios
               </button>
            </h2>
         </div>

         <div id="collapseOne" class="collapse show" aria-labelledby="usuarios" data-parent="#panel_lista">
            <div class="card-body">
               <a href="panel.php?section=form_usuario">Nuevo usuario</a>
               
               <div class='table-responsive'>
                  <table class="table table-bordered" id='lista_user'>
                     <thead class="thead-dark text-center">
                        <tr>
                           <th>Nombre</th>
                           <th>Apellido</th>
                           <th>Usuario</th>
                           <th>Email</th>
                           <th>Perfil</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                        while ($aUsers = mysqli_fetch_assoc($rta)):
                     ?>
                        <tr>
                           <td><?= $aUsers["nombre"]; ?></td>
                           <td><?= $aUsers["apellido"]; ?></td>
                           <td><?= $aUsers["usuario"]; ?></td>
                           <td><?= $aUsers["email"]; ?></td>
                           <td><?= $aUsers["rol"]; ?></td>
                           <td>
                              <div class="dropdown">
                                 <button class="btn btn-sm  dropdown-toggle" type="button"
                                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="panel.php?section=form_usuario&user=<?= $aUsers["id"]; ?>">Editar</a>
                                    
                                    <form action="borrar.php" method="post">
                                       <input type="hidden" name="user_id" value='<?= $aUsers["id"]; ?>'>
                                       <input type="submit" value="Eliminar">
                                    </form>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     <?php
                        endwhile;
                        mysqli_free_result($rta);
                     ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" id="platos">
            <h2 class="mb-0">
               <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Listado de platos
               </button>
            </h2>
         </div>
         <div id="collapseTwo" class="collapse" aria-labelledby="platos" data-parent="#panel_lista">
            <div class="card-body">
               <a href="panel.php?section=form_plato">Nuevo plato</a>
               <div class='table-responsive'>
                  <table class="table table-bordered">
                     <thead class="thead-dark text-center">
                        <tr>
                           <th>Id</th>
                           <th>Nombre</th>
                           <th>Tipo</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                        $query=<<<PLATOS
                              SELECT platos.id, nombre, tipo
                              FROM platos
                              JOIN tipos ON platos.tipo_id=tipos.id
                              ORDER BY platos.id;
PLATOS;
                        $rta=mysqli_query($conexion, $query);
                        while ($aPlatos = mysqli_fetch_assoc($rta)):
                     ?>
                        <tr>
                           <td><?= $aPlatos["id"]; ?></td>
                           <td><?= $aPlatos["nombre"]; ?></td>
                           <td><?= $aPlatos["tipo"]; ?></td>
                           <td>
                                 <div class="dropdown">
                                    <button class="btn btn-sm  dropdown-toggle" type="button"
                                             id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                             aria-expanded="false">
                                             <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       <a href="panel.php?section=form_plato&plato=<?= $aPlatos["id"]; ?>">Editar</a>
                                       
                                       <form action="borrar.php" method="post">
                                             <input type="hidden" name="plato_id" value='<?= $aPlatos["id"]; ?>'>
                                             <input type="submit" value="Eliminar">
                                       </form>
                                    </div>
                                 </div>
                           </td>
                        </tr>
                     <?php
                        endwhile;
                        mysqli_free_result($rta);
                     ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" id="adicionales">
            <h2 class="mb-0">
               <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Listado de adicionales
               </button>
            </h2>
         </div>
         <div id="collapseThree" class="collapse" aria-labelledby="adicionales" data-parent="#panel_lista">
            <div class="card-body">
               <a href="panel.php?section=form_adicional">Nuevo adicional</a>
               <div class='table-responsive'>
                  <table class="table table-bordered">
                     <thead class="thead-dark text-center">
                        <tr>
                           <th>Id</th>
                           <th>Nombre</th>
                           <th>Tipo</th>
                           <th>Precio</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                        $query=<<<PLATOS
                           SELECT adicionales.id, adicional, tipo, precio
                           FROM adicionales
                           JOIN tipos ON tipos.id=adicionales.tipo_id
                           ORDER BY id;
PLATOS;
                        $rta=mysqli_query($conexion, $query);
                        while ($aAdicionales = mysqli_fetch_assoc($rta)):
                     ?>
                        <tr>
                           <td><?= $aAdicionales["id"]; ?></td>
                           <td><?= $aAdicionales["adicional"]; ?></td>
                           <td><?= $aAdicionales["tipo"]; ?></td>
                           <td><?= $aAdicionales["precio"]; ?></td>
                           <td>
                                 <div class="dropdown">
                                    <button class="btn btn-sm  dropdown-toggle" type="button"
                                             id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                             aria-expanded="false">
                                             <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       <a href="panel.php?section=form_adicional&adicional=<?= $aAdicionales["id"]; ?>">Editar</a>
                                       
                                       <form action="borrar.php" method="post">
                                             <input type="hidden" name="adic_id" value='<?= $aAdicionales["id"]; ?>'>
                                             <input type="submit" value="Eliminar">
                                       </form>
                                    </div>
                                 </div>
                           </td>
                        </tr>
                     <?php
                        endwhile;
                        mysqli_free_result($rta);
                     ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   <?php
      endif;
   ?>
      <div class="card">
         <div class="card-header" id="pedidos">
            <h2 class="mb-0">
               <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Listado de pedidos
               </button>
            </h2>
         </div>
         <div id="collapseFour" class="collapse" aria-labelledby="pedidos" data-parent="#panel_lista">
            <div class="card-body">
               <div class='table-responsive'>
                  <table class="table table-bordered">
                     <thead class="thead-dark text-center">
                        <tr>
                           <th>Usuario</th>
                           <th>Pedido</th>
                           <th>Precio</th>
                           <th>Efectivo</th>
                           <th>Detalles</th>
                           <th>Estado</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                        $query=<<<PEDIDOS
                              SELECT usuario, pedido, precio, efectivo, estado
                              FROM pedidos_nro
                              JOIN usuarios ON usuarios.id=pedidos_nro.usuario_id
                              JOIN estados ON estados.id=pedidos_nro.estado_id
                              WHERE estado != 'Anulado'
                              GROUP BY pedido
                              ORDER BY pedidos_nro.id;
PEDIDOS;
                        $rta=mysqli_query($conexion, $query);
                        while (@$aPedidos = mysqli_fetch_assoc($rta)):
                     ?>
                        <tr>
                           <td><?= $aPedidos["usuario"]; ?></td>
                           <td><?= $aPedidos["pedido"]; ?></td>
                           <td><?= $aPedidos["precio"]; ?></td>
                           <td><?= $aPedidos["efectivo"] == 1 ? 'Si' : 'No'; ?></td>
                           <td><a href="panel.php?section=info_pedido&pedido=<?= $aPedidos["pedido"]; ?>"><i class="fas fa-info-circle"></i></a></td>
                           <td>
                              <div class="dropdown">
                                 <button class="btn btn-sm  dropdown-toggle" type="button"
                                          id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false">
                                    <?= $aPedidos["estado"]; ?>
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                 <?php
                                    $query="SELECT id, estado FROM estados WHERE id != 5;";

                                    $aEstados=Hacer_query($query, 'select', 2);
                                    foreach($aEstados as $estado):
                                 ?>
                                    <label><input type="radio" name="estado" value='<?= $estado['id'] ?>' onchange="this.form.submit()" form='form_estado' <?= $aPedidos["estado"] === $estado['estado'] ? 'checked' : '' ?> ><?= $estado['estado'] ?></label>
                                 <?php
                                    endforeach;
                                 ?>

                                    <form action="cambiar_estado.php" method="post" id='form_estado'>
                                       <input type="hidden" name="pedido" value='<?= $aPedidos["pedido"]; ?>'>
                                    </form>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     <?php
                        endwhile;
                        @mysqli_free_result($rta);
                     ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   
</section>