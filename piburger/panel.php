<!DOCTYPE html>
<?php
    require_once("config/config.php");
    require_once("config/arrays.php");
    require_once("config/functions.php");

    if(!isset($_SESSION['user']) || $_SESSION['user']['rol_id'] === 2 ):
        $_SESSION['error']='denegado';

        header('Location: index.php?section=home');
        die();

    endif;
    
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel</title>

    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/bootstrap.css">
    <link href="favicon.ico" rel="icon" type="image/ico" />
    <link href="fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<header id='panel'>
    <h1><a href="panel.php?section=lista_panel">Pi Panel</a></h1>

    <nav>
        <p><i class="fas fa-user-circle"></i></p>
        
        <div class='botones'>
            <ul>
                <li><a href="index.php?section=perfil"><?= $_SESSION['user']['usuario'] ?></a></li>
                <li><a href="logout.php">Log-out</a></li>
                <li><a href="index.php">Pi Burger</a></li>
            </ul>
        </div>

    </nav>
</header>
<main>
    <?php
        $section=$_GET['section'] ?? 'lista_panel';

        if(file_exists("panel/$section.php")):
            require_once("panel/$section.php");
    
        else:
            require_once("section/404.php");
    
        endif;
    ?>
</main>
<footer>
    <p>Pi Burgers &copy;. Todos los derechos reservados 2019</p>
</footer>

<script src="js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>

<?php
    unset($_SESSION['error']);
    unset($_SESSION['ok']);
    unset($_SESSION['datos']);
?>
</body>
</html>