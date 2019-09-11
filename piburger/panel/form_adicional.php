<?php
    $query=<<<TIPOS
            SELECT id, tipo
            FROM tipos
            ORDER BY id;
TIPOS;

    $aTipos=Hacer_query($query, 'select', 2);

    $nombre=isset($_SESSION['datos']['nombre']) ? $_SESSION['datos']['adicional'] : '';
    $tipo_plato=isset($_SESSION['datos']['tipo']) ? $_SESSION['datos']['tipo'] : '';
    $precio=isset($_SESSION['datos']['precio']) ? $_SESSION['datos']['precio'] : '';

    if(isset($_GET['adicional'])):
        $boton='Actualizar';
        $titulo='Editar adcional';
        $adic=$_GET['adicional'];

        $query=<<<ADICIONAL
            SELECT adicionales.id, adicional, tipo, precio
            FROM adicionales
            JOIN tipos ON tipos.id=adicionales.tipo_id
            WHERE adicionales.id=$adic
ADICIONAL;

        $aAdicional=Hacer_query($query, 'select', 1);

        if(!$aAdicional):
            header('Location: panel.php?section=lista_panel');
            die();

        endif;

        $nombre=isset($aAdicional) ? $aAdicional['adicional'] : '';
        $tipo_plato=isset($aAdicional) ? $aAdicional['tipo'] : '';
        $precio=isset($aAdicional) ? $aAdicional['precio'] : '';

    else:
        $boton='Agregar';
        $titulo='Agregar adicional';

    endif;
?>
<section id='form_adicional'>
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

    <form action="adicional_db.php" method='post'>
        <div>
            <div>
                <label>Nombre</label>
                <input type="text" name='nombre' value='<?= $nombre ?>'>
            
                <div class='error'>
                    <?php
                        if(isset($_SESSION['error']) && $_SESSION['error']=== 'adicional'):
                            echo $aErrores['adicional'];
            
                        elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'adicional_existe'):
                            echo $aErrores['adicional_existe'];
            
                        endif;
                    ?>
                </div>
            </div>

            <div>
                <div id='tipo_adicional'>
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
                <label>Precio</label>
                <input type="number" name="precio" value='<?= $precio ?>'>
                <div class='error'>
                    <?= isset($_SESSION['error']) && $_SESSION['error']=== 'precio' ? $aErrores['precio'] : '' ?>
                </div>
            </div>

        </div>

        <input type="hidden" name="id" value='<?= isset($_GET['adicional']) ? $_GET['adicional'] : ''; ?>'>

        <input type="submit" value="<?= $boton; ?>">
    </form>
</section>