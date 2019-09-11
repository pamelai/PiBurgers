<?php
    $query=<<<TIPOS
            SELECT id, tipo
            FROM tipos
            ORDER BY id;
TIPOS;

    $aTipos=Hacer_query($query, 'select', 2);

    $nombre=isset($_SESSION['datos']['nombre']) ? $_SESSION['datos']['nombre'] : '';
    $descripcion=isset($_SESSION['datos']['descripcion']) ? $_SESSION['datos']['descripcion'] : '';
    $tipo_plato=isset($_SESSION['datos']['tipo']) ? $_SESSION['datos']['tipo'] : '';

    if(isset($_GET['plato'])):
        $boton='Actualizar';
        $titulo='Editar plato';
        $plato=$_GET['plato'];

        $query=<<<PLATO
        SELECT nombre, descripcion, img, tipo, precio
        FROM platos
        JOIN tipos ON platos.tipo_id=tipos.id
        WHERE platos.id=$plato
PLATO;

        $aPlato=Hacer_query($query, 'select', 1);

        if(!$aPlato):
            header('Location: panel.php?section=lista_panel');
            die();

        endif;

        $nombre=isset($aPlato) ? $aPlato['nombre'] : '';
        $descripcion=isset($aPlato) ? $aPlato['descripcion'] : '';
        $tipo_plato=isset($aPlato) ? $aPlato['tipo'] : '';
        $precio=isset($aPlato) ? $aPlato['precio'] : '';

    else:
        $boton='Agregar';
        $titulo='Agregar plato';

    endif;
?>
<section id='form_plato'>
    <h2><?= $titulo ?></h2>

    <div class='error'>
        <?php 
             if(isset($_SESSION['error']) && $_SESSION['error']=== 'update_db'):
                echo $aErrores['update_db'];

            elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'agregar_db'):
                echo $aErrores['agregar_db'];

            endif;
        
        ?>
        
    </div>

    <form action="plato_db.php" method='post' enctype='multipart/form-data'>
        <div>
            <label>
                <figure>
                    <img src="<?= isset($aPlato) ? 'img/platos/'.$aPlato['img'] : 'img/platos/plato_defecto.jpg' ?>" alt="<?= isset($aPlato) ? $aPlato['nombre'] : 'plato_nuevo' ?>">
                </figure>

                <input type="file" name="img" accept='image/jpeg'>
            </label>
            <div class='error'>
                <?php 
                    if(isset($_SESSION['error']) && $_SESSION['error']=== 'type_img'):
                        echo $aErrores['type_img'];
        
                    elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'img'):
                        echo $aErrores['img'];
        
                    endif;
                ?>
            </div>
        </div>

        <div>
            <div>
                <label>Nombre</label>
                <input type="text" name='nombre' value='<?= $nombre ?>'>
            
                <div class='error'>
                    <?php
                        if(isset($_SESSION['error']) && $_SESSION['error']=== 'nombre'):
                            echo $aErrores['nombre'];
            
                        elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'nombre_existe'):
                            echo $aErrores['nombre_existe'];
            
                        endif;
                    ?>
                </div>
            </div>

            <div>
                <div id='tipo_plato'>
                    <label>Tipo</label>
                    <select name="tipo">
                        <option value="" disabled selected>Seleccionar tipo</option>

                        <?php
                            foreach($aTipos as $tipo):
                        ?>

                            <option value="<?= $tipo['id'] ?>" <?= $tipo_plato === $tipo['tipo'] || $tipo_plato === $tipo['id'] ? 'selected' : ''  ?>><?= $tipo['tipo'] ?></option>

                        <?php
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class='error'>
                    <?= isset($_SESSION['error']) && $_SESSION['error'] === 'tipo' ? $aErrores['tipo'] : ''; ?>
                </div>
            </div>

            <div>
                <label>Descripción</label>
                <textarea name="descripcion"><?= $descripcion ?></textarea>
                <div class='error'>
                    <?= isset($_SESSION['error']) && $_SESSION['error']=== 'desc' ? $aErrores['desc'] : '' ?>
                </div>
            </div>

            <div>
                <label>Precio</label>
                <input type="number" name="precio" value='<?= $precio ?>'>
                <div class='error'>
                    <?= isset($_SESSION['error']) && $_SESSION['error']=== 'precio' ? $aErrores['precio'] : '' ?>
                </div>
            </div>

        </div>

        <input type="hidden" name="id" value='<?= isset($_GET['plato']) ? $_GET['plato'] : ''; ?>'>

        <input type="submit" value="<?= $boton; ?>">
    </form>
</section>