<?php
   require_once('config/config.php');
   require_once('config/functions.php');

   define('URL', 'index.php?section=perfil');

   foreach($_POST as $dato => $valor):
      $aDatosPost[$dato]=mysqli_real_escape_string($conexion, htmlentities($valor));

      if(!empty($dato) && $dato !== 'nro_tar' && $dato !== 'cvv' && $dato !== 'clave' && $dato !== 'pass'):
         $_SESSION['datos'][$dato]=$valor;

      endif;

   endforeach;

   $nombre=$aDatosPost['nombre'] ? $aDatosPost['nombre']: null;
   $apellido=$aDatosPost['apellido'] ? $aDatosPost['apellido'] : null;
   $email=$aDatosPost['email'];
   $user=$aDatosPost['usuario'];
   $pass=$aDatosPost['pass'];
   $id=$aDatosPost['id'];

   $metodo=$aDatosPost['metodo'];
   $titular=$aDatosPost['titular'];
   $nro_tar=$aDatosPost['nro_tar'];
   $vencimiento=$aDatosPost['vencimiento'];
   $cvv=$aDatosPost['cvv'];

   $calle=$aDatosPost['calle'];
   $nro=$aDatosPost['nro'];
   $ciudad=$aDatosPost['ciudad'];
   $prov=$aDatosPost['prov'];

   $tel=$aDatosPost['tel'];

   $borrar_tc=$aDatosPost['borrar_tc'];
   $borrar_direc=$aDatosPost['borrar_direc'];
   $borrar_tel=$aDatosPost['borrar_tel'];

   
   if(isset($email) && empty($email)):
      $_SESSION['error']='email';
      header('Location:'. URL);
      die();

   elseif(isset($user) && empty($user)):
      $_SESSION['error']='user';
      header('Location:'. URL);
      die();

   elseif(isset($pass) && empty($pass)):
      $pass=$_SESSION['user']['pass'];

   else:
      $pass=$_SESSION['user']['pass'];

      if(!password_verify($pass, $pass_hash)):
         $pass=password_hash($pass, PASSWORD_DEFAULT);
         
      endif;

   endif;


   if(isset($titular) && empty($metodo)):
      $_SESSION['error']='metodo';

      header ('Location:'.URL);
      die();

   elseif(isset($titular) && empty($titular)):
      $_SESSION['error']='titular';

      header ('Location:'.URL);
      die();

   elseif(isset($nro_tar) && empty($nro_tar)):
      $_SESSION['error']='nro_tar';

      header ('Location:'.URL);
      die();

   elseif(isset($nro_tar) && (($metodo !== 6 && strlen($nro_tar) !== 16) || ($metodo == 6 && strlen($nro_tar) !== 19))):
      $_SESSION['error']='nro_tar_erroneo';

      header ('Location:'.URL);
      die();

   elseif(isset($vencimiento) && empty($vencimiento)):
      $_SESSION['error']='vencimiento';

      header ('Location:'.URL);
      die();

   elseif(isset($cvv) && empty($cvv)):
      $_SESSION['error']='cvv';

      header ('Location:'.URL);
      die();

   elseif(isset($cvv) && $metodo === '4' && strlen($cvv) !== 4):
      $_SESSION['error']='cvv_american';

      header ('Location:'.URL);
      die();
      
   elseif(isset($cvv) && $metodo !== '4' && strlen($cvv) !== 3):
      $_SESSION['error']='cvv_error';

      header ('Location:'.URL);
      die();

   elseif(isset($calle) && empty($calle)):
      $_SESSION['error']='calle';

      header ('Location:'.URL);
      die();

   elseif(isset($nro) && empty($nro)):
      $_SESSION['error']='nro';

      header ('Location:'.URL);
      die();

   elseif(isset($calle) && empty($ciudad)):
      $_SESSION['error']='ciudad';

      header ('Location:'.URL);
      die();

   elseif(isset($calle) && empty($prov)):
      $_SESSION['error']='prov';

      header ('Location:'.URL);
      die();

   elseif(isset($calle) && (($prov == 2 && $ciudad !== 4) || ($prov == 1 && $ciudad == 4))):
      $_SESSION['error']='prov_error';

      header ('Location:'.URL);
      die();

   elseif(isset($tel) && empty($tel)):
      $_SESSION['error']='tel_db';

      header ('Location:'.URL);
      die();

   endif;


   if(!empty($_FILES['img']) && $_FILES['img']['error'] === 0):
      $img=$_FILES['img'];
      
      if(in_array($img['type'], $aType_img)):
         $type=explode('/', $img['type'])[1];

      else:
         $_SESSION['error']='type_img';

         header("Location:".URL);
         die();

      endif;
      
      $abrirImg="imagecreatefrom$type";
      $imgOrig= $abrirImg($img['tmp_name']);

      $anchoOrig=imagesx($imgOrig);
      $altoOrig=imagesy($imgOrig);

      $anchoNew=300;
      $altoNew= 300;

      $lienzoNew=imagecreatetruecolor($anchoNew, $altoNew);

      if($type != 'jpeg'):
         imagesavealpha($lienzoNew,true);
         imagealphablending($lienzoNew,false);
      endif;

      imagecopyresampled($lienzoNew,$imgOrig,0,0,0,0,$anchoNew,$altoNew,300,300);

      header("Content-type:image/$type");

      if(!is_dir("img/usuarios/$email")):
         mkdir("img/usuarios/$email");

      endif;

      $export = "image$type";

      if($type == "jpeg"):
         $calidad = 75;

      else:
         $calidad = 7;

      endif;

      $export($lienzoNew,"img/usuarios/$email/avatar.$type",$calidad);

      $rutaImagen = "img/usuarios/$email/avatar.$type";
      
   elseif(isset($_SESSION['user']['img'])):
      $rutaImagen=$_SESSION['user']['img'];

   else:
      $rutaImagen='img/usuarios/user_img.png';
      
   endif;

   
   if(isset($user)):
      $query='UPDATE usuarios SET ';

      if($nombre === null):
         $query.='nombre=null,';

      else:
         $query.="nombre='$nombre',";
         
      endif;
      
      if($apellido === null):
         $query.='apellido=null,';

      else:
         $query.="apellido='$apellido',";
         
      endif;

      $query.="img='$rutaImagen', email='$email', usuario='$user', pass='$pass' WHERE id=$id;";
      
      $update=Hacer_query($query, 'update', null);

   elseif(isset($titular)):
      $vencimiento.='-01';
      
      $query="INSERT INTO tarjetas (nro, vencimiento, titular, cvv, usuario_id, tipo_tarjeta_id) VALUES ($nro_tar, '$vencimiento', '$titular', $cvv, $id, $metodo)";

      $insert=Hacer_query($query, 'insert', null);

   elseif(isset($calle)):
      $query="INSERT INTO domicilios (calle, nro, prov_id, cd_id, usuario_id) VALUES ('$calle', $nro, $prov, $ciudad, $id)";

      $insert=Hacer_query($query, 'insert', null);

   elseif(isset($tel)):
      $query="INSERT INTO telefonos (tel, usuario_id) VALUES ($tel , $id)";

      $insert=Hacer_query($query, 'insert', null);
      
   elseif(isset($borrar_tc)):
      $query="DELETE FROM tarjetas WHERE id=$borrar_tc";

      $delete=Hacer_query($query, 'delete', null);

   elseif(isset($borrar_direc)):
      $query="DELETE FROM domicilios WHERE id=$borrar_direc";

      $delete=Hacer_query($query, 'delete', null);

   elseif(isset($borrar_tel)):
      $query="DELETE FROM telefonos WHERE id=$borrar_tel";

      $delete=Hacer_query($query, 'delete', null);

   endif;

   if($update):
      $query=<<<DATOS
               SELECT * 
               FROM usuarios
               WHERE id='$id';
DATOS;

      $aDatos=Hacer_query($query, 'select', null);
      $_SESSION['user']=$aDatos;

   endif;


   if($update || $insert || $delete):
      $_SESSION['ok']='update_db';
      header('Location:'.URL);
      unset($_SESSION['datos']);

   else:
      $_SESSION['error']='update_db';
      header('Location:'.URL);

   endif;