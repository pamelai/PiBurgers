<?php
    if(!isset($_SESSION['user'])):
        $_SESSION['error']='denegado';

        header('Location: index.php?section=home');
        die();

    endif;
    
    $query=<<<BURGERS
            SELECT id, nombre
            FROM platos
            WHERE tipo_id=1;
BURGERS;

    $aBurgers=Hacer_query($query, 'select', 2);

    $query=<<<TIPO_BURGER
            SELECT id, tipo
            FROM tipos_hamburguesas; 
TIPO_BURGER;

    $aTipo_burger=Hacer_query($query, 'select', 2);

    $query=<<<ADICIONALES
        SELECT id, adicional
        FROM adicionales
        WHERE tipo_id=1;

ADICIONALES;

    $aAdicionales=Hacer_query($query, 'select', 2);

    $query=<<<BEBIDAS
        SELECT id, adicional
        FROM adicionales
        WHERE tipo_id=4;

BEBIDAS;

    $aBebidas=Hacer_query($query, 'select', 2);

    $query=<<<PAPAS
        SELECT id, adicional
        FROM adicionales
        WHERE tipo_id=3;

PAPAS;

    $aFries=Hacer_query($query, 'select', 2);

    $query=<<<HOTDOG
            SELECT id, nombre
            FROM platos
            WHERE tipo_id=2;
HOTDOG;

    $aHotdogs=Hacer_query($query, 'select', 2);

    $query=<<<BEBIDAS
        SELECT id, adicional
        FROM adicionales
        WHERE tipo_id=2;

BEBIDAS;

    $aPapasPay=Hacer_query($query, 'select', 1);
?>

<div id='realizar_pedidos' class="encabezado">
    <h2>Pedidos</h2>
</div>

<section>
    <p>Por favor, ingresá un plato por pedido</p>

    <div class='<?= Class_msj() ?>'>
        <?php

            if(isset($_SESSION['ok'])):
                echo $aOks['combo'];

            elseif(isset($_SESSION['error'])):
                if($_SESSION['error'] === 'plato_vacio'):
                    echo $aErrores['plato_vacio'];

                elseif($_SESSION['error'] === 'plato_doble'):
                    echo $aErrores['plato_doble'];
                    
                elseif($_SESSION['error'] === 'adicional'):
                    echo $aErrores['adicional'];
                    
                elseif($_SESSION['error'] === 'tipo'):
                    echo $aErrores['tipo'];

                elseif($_SESSION['error'] === 'cant'):
                    echo $aErrores['cant'];
                    
                elseif($_SESSION['error'] === 'combo'):
                    echo $aErrores['combo'];
                    
                endif;
            endif;
        ?>
    </div>

    <div class="accordion" id="hacer_pedido">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#burgers" role="button" aria-expanded="true" aria-controls="burgers">Burgers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#hotdog" role="button" aria-expanded="false" aria-controls="hotdog">Grilled Hot Dogs</a>
                    </li>
                </ul>
            </div>
            
            <div class="collapse show" id="burgers" data-parent="#hacer_pedido">
                <div class="card card-body">
                    <div>
                        <label>Burgers</label>
                        <select name="burger" form='combo'>
                            <option value="" disabled selected>Seleccionar</option>

                            <?php
                                foreach($aBurgers as $burger):
                            ?>

                                <option value="<?= $burger['id'] ?>" <?= isset($_SESSION['datos']['burger']) && $_SESSION['datos']['burger'] === $burger['id'] ? 'selected' : ''; ?> ><?= $burger['nombre'] ?></option>

                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>

                    <div>
                        <label>Tipo</label>
                        <select name="tipo" form='combo'>
                            <option value="" disabled selected>Seleccionar</option>

                            <?php
                                foreach($aTipo_burger as $tipo_burger):
                            ?>

                                <option value="<?= $tipo_burger['id'] ?>" <?= isset($_SESSION['datos']['tipo']) && $_SESSION['datos']['tipo'] === $tipo_burger['id'] ? 'selected' : ''; ?> ><?= $tipo_burger['tipo'] ?></option>

                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>

                    <div>
                        <label>Adicionales</label>

                        <div>
                        <?php
                            $cont=1;
                            foreach($aAdicionales as $adicional):
                        ?>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="adicional<?= $cont ?>" name="adicional<?= $cont ?>" value="<?= $adicional['id'] ?>"  form='combo' <?= isset($_SESSION['datos']["adicional$cont"]) && $_SESSION['datos']["adicional$cont"] === $adicional['id'] ? 'checked' : '';?>>
                                <label class="custom-control-label" for="adicional<?= $cont ?>"><?= $adicional['adicional'] ?></label>
                            </div>

                        <?php
                            $cont++;
                            endforeach;
                        ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="collapse" id="hotdog" data-parent="#hacer_pedido">
                <div class="card card-body">
                    <div>
                        <label>Hot Dog</label>
                        <select name="hotdog" form='combo'>
                            <option value="" disabled selected>Seleccionar</option>

                            <?php
                                foreach($aHotdogs as $hotdog):
                            ?>

                                <option value="<?= $hotdog['id'] ?>" <?= isset($_SESSION['datos']['hotdog']) && $_SESSION['datos']['hotdog'] === $hotdog['id'] ? 'selected' : ''; ?> ><?= $hotdog['nombre'] ?></option>

                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    
                    <div>
                        <label>Adicionales</label>
                        <select name="papas_pay" form='combo'>
                            <option value="" disabled selected>Sin adicional</option>
                            <option value="<?= $aPapasPay['id'] ?>" <?= isset($_SESSION['datos']['papas_pay']) && $_SESSION['datos']['papas_pay'] === $aPapasPay['id'] ? 'selected' : ''; ?> ><?= $aPapasPay['adicional'] ?></option>

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="realizar_pedido.php" method="post" id='combo'>

        <div>
            <label>Fries</label>
            <select name="fries">
                <option value="" disabled selected>Seleccionar</option>

                <?php
                    foreach($aFries as $fries):
                ?>

                    <option value="<?= $fries['id'] ?>" <?= isset($_SESSION['datos']['fries']) && $_SESSION['datos']['fries'] === $fries['id'] ? 'selected' : ''; ?> ><?= $fries['adicional'] ?></option>

                <?php
                    endforeach;
                ?>
            </select>
        </div>
        
        <div>
            <label>Bebidas</label>
            <select name="bebida">
                <option value="" disabled selected>Seleccionar</option>

                <?php
                    foreach($aBebidas as $bebida):
                ?>

                    <option value="<?= $bebida['id'] ?>" <?= isset($_SESSION['datos']['bebida']) && $_SESSION['datos']['bebida'] === $bebida['id'] ? 'selected' : ''; ?> ><?= $bebida['adicional'] ?></option>

                <?php
                    endforeach;
                ?>
            </select>
        </div>

        <div>
            <label>Cantidad</label>
            <input type="number" name="cant" value='<?= isset($_SESSION['datos']["cant"]) ? $_SESSION['datos']["cant"] : 1; ?>' min='1''>
        </div>

        <input type="hidden" name="user" value='<?= $_SESSION['user']['id'] ?>'>

        <input type="submit" value="Agregar al pedido">
    
    </form>
</section>