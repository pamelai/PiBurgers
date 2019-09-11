<?php
    if(empty($_GET['id'])):
        header('Location:index.php?section=menu');
        die();

    else:
        $id=$_GET['id'];

    endif;

    $query=<<<PLATO
        SELECT nombre, descripcion, img
        FROM platos
        WHERE id=$id;
PLATO;

    $aPlato=Hacer_query($query, 'select', 1);

    if(!$aPlato):
        header('Location:index.php?section=menu');
        die();

    endif;
?>

<div class='encabezado' id='detalle'>
    <h2><?= $aPlato['nombre'] ?></h2>
</div>

<section>
    <p><a href="index.php?section=menu">Volver</a></p>

    <div>
        <figure>
            <img src="<?= RUTA.$aPlato['img'] ?>" alt="<?= $aPlato['nombre'] ?>">
        </figure>

        <p> <?= $aPlato['descripcion'] ?> </p>
    </div>

</section>
<section>
    <h2>Reseñas</h2>

    <div class='<?= Class_msj() ?>'>
        <?php
            if(isset($_SESSION['ok'])):
                echo $aOks['review'];

            elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'review'):
                echo $aErrores['review'];

            endif;
        ?>
    </div>

    <!-- Comentarios -->
    <?php    
        $query=<<<COMENTARIOS
                SELECT comentario, puntuacion, usuario, img
                FROM comentarios
                JOIN usuarios ON usuarios.id=comentarios.usuario_id
                WHERE plato_id=$id;
COMENTARIOS;
    
        $rta=mysqli_query($conexion, $query);

        if(!mysqli_num_rows($rta)):
    ?>

        <p>No hay comentarios disponibles</p>

    <?php 
        else:
    ?>
        <ul id='comments'>
            <?php
                while($aComments = mysqli_fetch_assoc($rta)):
            ?>

                <li>
                    <h3><?= $aComments['usuario'] ?></h3>
                
                    <div id='calif_comment'>
                        <input type="radio" disabled <?= $aComments['puntuacion']=== '5' ?'checked' : ''; ?>>
                        <label >&#9733;</label>
                        <input type="radio" disabled <?= $aComments['puntuacion']=== '4' ?'checked' : ''; ?>>
                        <label >&#9733;</label>
                        <input type="radio" disabled <?= $aComments['puntuacion']=== '3' ?'checked' : ''; ?>>
                        <label >&#9733;</label>
                        <input type="radio" disabled <?= $aComments['puntuacion']=== '2' ?'checked' : ''; ?>>
                        <label >&#9733;</label>
                        <input type="radio" disabled <?= $aComments['puntuacion']=== '1' ?'checked' : ''; ?>>
                        <label >&#9733;</label>
                    </div>

                    <?php
                        if($aComments['comentario'] !== null):
                    ?>

                        <p><?= $aComments['comentario'] ?></p>

                    <?php
                        endif;
                    ?>
                </li>
        
        <?php
                endwhile;
                mysqli_free_result($rta);
            endif;
        ?>
        </ul>
    
    <!-- Form -->
    <?php
        if(!isset($_SESSION['user'])):
    ?>

        <div class='error'>
            <?= $aErrores['comments']?>
        </div>

    <?php
        else:
    ?>
        <h3>Dejá tu comentario</h3>

        <form action="reviews.php" method='post'>
            <label>Calificación</label>
            <div id='calificacion'>
                <input type="radio" name="stars" id="star_5" value='5'>
                <label for="star_5">&#9733;</label>
                <input type="radio" name="stars" id="star_4" value='4'>
                <label for="star_4">&#9733;</label>
                <input type="radio" name="stars" id="star_3" value='3'>
                <label for="star_3">&#9733;</label>
                <input type="radio" name="stars" id="star_2" value='2'>
                <label for="star_2">&#9733;</label>
                <input type="radio" name="stars" id="star_1" value='1'>
                <label for="star_1">&#9733;</label>
            </div>
            <div class='error'>
                <?= isset($_SESSION['error']) && $_SESSION['error']=== 'stars' ? $aErrores['stars'] : ''; ?>
            </div>

            <label>Comentario</label>
            <textarea name="comentario"></textarea>

            <input type="hidden" name="id" value='<?= isset($_SESSION['user']) ? $_SESSION['user']['id'] : ''; ?>'>
            <input type="hidden" name="plato" value='<?= $id ?>'>

            <input type="submit" value="Enviar">

        </form>

    <?php
        endif;
    ?>

</section>