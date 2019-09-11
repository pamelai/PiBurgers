<!DOCTYPE html>
<?php 
   require_once("config/config.php");
   require_once("config/arrays.php");
   require_once("config/functions.php");

   $user=isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

   if($user):
      $aPlatos=@$_SESSION['pedidos'];
      $aPedidos=@$_SESSION['checkout'];
      
   endif;

?>

<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
   
   <title>Pi Burgers</title>
   
   <link rel="stylesheet" href="estilos/estilos.css">
   <link rel="stylesheet" href="estilos/slick.css">
   <link href="favicon.ico" rel="icon" type="image/ico" />
   <link href="fontawesome/css/all.css" rel="stylesheet">
   <link rel="stylesheet" href="estilos/bootstrap.css">
</head>
<body>
<header>
   <h1><a href="index.php?section=home">Pi Burgers</a></h1>

   
   <nav>
      <p>Abrir/Cerrar</p>
      
      <div class='botones'>
         <ul>
               <?php
                  foreach($aNav as $nav):

               ?>

               <li><a class="<?= Section( $nav['class'] ) ?>" href="<?= $nav['href'] ?>"><?= $nav['nombre'] ?></a></li>

               <?php
                  endforeach;
               ?>
         </ul>
      </div>
   </nav>
      
   <div>
      <div class='botones'>
         <ul>
            <li>
               <div class="dropdown" id='<?= $user === '' ? 'no_logeado' : ''; ?>'>
                  <button class="btn" type="button" id="pedidos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fas fa-burger-soda"></i>  
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pedidos">
                     <?php
                        if($aPlatos && $aPlatos['total']):
                           $total=0;
                     ?>
                        <ul>
                        <?php
                           foreach($aPlatos as $plato):
                              if(is_array($plato)):
                                 foreach($plato as $detalle):
                                    $total+=$detalle['precio'];
                              
                        ?>  
                                 <li><?= $detalle['nombre']?>  <span><?= $detalle['precio'] ?></span> </li>

                     <?php
                                 endforeach;
                              endif;
                           endforeach;
                     ?>
                           
                        </ul>

                        <p id='total'>Total: <span><?= $total ?></span></p>

                     <?php
                        else:
                     ?>
                        <p>No tienes ningún combo <a href="index.php?section=hacer_pedido">Realizar pedido</a></p>
                     <?php
                        endif;
                     ?>

                     <a class="dropdown-item" href="index.php?section=pedidos">Ver más</a>
                  </div>
               </div>
            </li>
            <li>
               <div class="dropdown">
                  <button class="btn" type="button" id="user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user">
                  <?php
                     if(isset($_SESSION['user'])):
                        if($_SESSION['user']['rol_id'] != 2):
                  ?>
                        <a class="dropdown-item" href="panel.php?section=lista_panel">Panel</a>
                  <?php
                        endif;
                        foreach($aLogeado as $log):
                  ?>

                     <a class="dropdown-item <?= Section( $log['class'] ) ?> " href="<?= $log['href'] ?>"><?= $log['nombre'] ?></a>

                  <?php
                        endforeach;
                     else:
                        foreach($aSesion as $sesion):

                  ?>

                     <a class="dropdown-item <?= Section( $sesion['class'] ) ?>" href="<?= $sesion['href'] ?>"><?= $sesion['nombre'] ?></a>

                  <?php
                        endforeach;

                     endif;
                  ?>
                  </div>
               </div>
            </li>
         </ul>
      </div>
   </div>
</header>
<main>

   <?php
      $section=$_GET['section'] ?? 'home';

      if(isset($_GET["b"])):
         require_once("section/menu.php");
         
     else:
         if(file_exists("section/$section.php")):
            require_once("section/$section.php");
      
         else:
            require_once("section/404.php");
      
         endif;
      endif;
      
      if(isset($_SESSION['user'])):
   ?>
      <a id='btn_pedido' href="index.php?section=hacer_pedido"><i class="fas fa-burger-soda"></i><span>Realizar pedido</span></a>
   <?php
      endif;
   ?>
</main>
<footer>
   <ul>
      <li><a href="https://es-la.facebook.com/">Facebook</a></li>
      <li><a href="https://twitter.com/?lang=es">Twitter</a></li>
      <li><a href="https://www.instagram.com/?hl=es-la">Instagram</a></li>
   </ul>
   
   <p>Pi Burgers &copy;. Todos los derechos reservados 2019</p>
</footer>

<script src="js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
<script src="js/slick.min.js"></script>

<?php
   unset($_SESSION['error']);
   unset($_SESSION['ok']);
   unset($_SESSION['datos']);
?>

</body>
</html>