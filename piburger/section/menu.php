    <?php
        $query=<<<TIPOS
                SELECT tipos.id, tipo
                FROM tipos
                JOIN platos ON platos.tipo_id=tipos.id
                GROUP BY tipo;
TIPOS;

    $aTipos=Hacer_query($query, 'select', 2);


    ?>
    
    <div id='menu' class="encabezado">
        <h2>Menú</h2>
    </div>
    
    <section>
        <form method="GET" action="index.php">
        <div class="input-group">
            <div class="input-group-prepend">
            <div class="input-group-text"><i class="far fa-search"></i></div>
            </div>
            <input class="form-control" name="b" type="search" placeholder="Buscar" aria-label="Buscar">
            <div class="input-group-append">
                <button class="btn" type="submit">Buscar</button>
            </div>
        </div>
            
        </form>
        <?php
        if(isset($_GET["b"])):
            $buscar = mysqli_real_escape_string($conexion,$_GET["b"]); 
            $query = "SELECT id, nombre, descripcion, img FROM platos WHERE nombre LIKE '%$buscar%';";

            $aPlatos=Hacer_query($query, 'select', 2);

                
        ?>
            <ul class='platos'>
            <?php
                foreach($aPlatos as $plato):
            ?>
                <li>
                    <a href="index.php?section=platos_detalle&id=<?= $plato['id']; ?>">
                        <figure>
                            <img src="<?= RUTA.$plato['img']; ?>" alt="<?= $plato['nombre']; ?>">
                        </figure>
                    </a>
                </li>
            <?php
                endforeach;
            ?>
            </ul>
        
        <?php
        else:
            foreach($aTipos as $tipo):
                $id=$tipo['id'];
        ?>

        <h3><?= $tipo['tipo'] ?></h3>
        <ul class='platos'>
            <?php
                $query=<<<PLATOS
                        SELECT id, nombre, descripcion, img, tipo_id
                        FROM platos
                        WHERE tipo_id= $id;
PLATOS;

                $aPlatos=Hacer_query($query, 'select', 2);

                foreach($aPlatos as $plato):

            ?>  

            <li>
                <a href="index.php?section=platos_detalle&id=<?= $plato['id']; ?>">
                    <figure>
                        <img src="<?= RUTA.$plato['img']; ?>" alt="<?= $plato['nombre']; ?>">
                    </figure>
                </a>
            </li>

            <?php
                endforeach;
            ?>
        </ul>

        <?php
            endforeach;
        endif;
        ?>

        
    </section>