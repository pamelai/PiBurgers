<div id='contacto' class='encabezado'>
        <h2 >Contacto</h2>
    </div>
     
    <section>
        <p>¿Tenés alguna duda, sugerencia o queja?  Acá estamos a tu servicio</p>
        
        <div>
            <iframe src="https://maps.google.com/maps?q=Capital%20Federal%2C%20Buenos%20Aires&amp;t=m&amp;z=16&amp;output=embed&amp;iwloc=near"></iframe>

            <form method="post" enctype="multipart/form-data" action="contactar.php">
               
                <div>
                    <label>Nombre</label>
                    <input type="text" name="nombre" value='<?= isset($_SESSION['datos']['nombre']) ? $_SESSION['datos']['nombre'] : ''; ?>'>

                </div>
                <div>
                    <label>Apellido</label>
                    <input type="text" name="apellido" value='<?= isset($_SESSION['datos']['apellido']) ? $_SESSION['datos']['apellido'] : ''; ?>'>

                </div>
                <div>
                    <label>Correo electrónico <span>*</span></label>
                    <input type="email" name="email" value="<?= isset($_SESSION['datos']['email']) ? $_SESSION['datos']['email'] : ''; ?>">

                    <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='email' ? $aErrores['email'] : '';
                         ?>
                    </div>

                </div>
                <div>
                    <label>Motivo <span>*</span></label>
                    <div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="duda" name="motivo1" value="duda" form='combo' <?= isset($_SESSION['datos']['motivo1']) && $_SESSION['datos']['motivo1'] === 'duda' ? 'checked' : ''; ?> >
                            <label class="custom-control-label" for="duda">Duda</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sugerencia" name="motivo2" value="sugerencia" form='combo' <?= isset($_SESSION['datos']['motivo2']) && $_SESSION['datos']['motivo2'] === 'sugerencia' ? 'checked' : ''; ?> >
                            <label class="custom-control-label" for="sugerencia">Sugerencia</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="queja" name="motivo3" value="queja" form='combo' <?= isset($_SESSION['datos']['motivo3']) && $_SESSION['datos']['motivo3'] === 'queja' ? 'checked' : ''; ?> >
                            <label class="custom-control-label" for="queja">Queja</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="otro" name="motivo4" value="otro" form='combo' <?= isset($_SESSION['datos']['motivo4']) && $_SESSION['datos']['motivo4'] === 'otro' ? 'checked' : ''; ?> >
                            <label class="custom-control-label" for="otro">Otro</label>
                        </div>

                    </div>

                    <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='motivo' ? $aErrores['motivo'] : ''; ?>
                    </div>

                </div>  
                <label>Comentario<span>*</span></label>
                    <textarea name="comentario" ><?= isset($_SESSION['datos']['coment']) ? $_SESSION['datos']['coment'] : ''; ?></textarea>

                    <div class='error'>
                        <?= isset($_SESSION['error']) && $_SESSION['error']==='comentario' ? $aErrores['comentario'] : ''; ?>
                    </div>

                <input type="submit" name='Enviar' value="Enviar">

                <div class='ok'>
                    <?php 
                        if(isset($_SESSION['ok'])):
                             echo $aOks['enviado']; 

                        endif;
                    ?>
                </div>

            </form>
        </div>
        <div>
            <div>
                <h3>Llamanos</h3>
                <p>Líneas rotativas: 0800-222-486</p>
            </div>
            <div>
                <h3>Seguinos</h3>
                <ul>
                    <li><a href="https://es-la.facebook.com/">Facebook</a></li>
                    <li><a href="https://twitter.com/?lang=es">Twitter</a></li>
                    <li><a href="https://www.instagram.com/?hl=es-la">Instagram</a></li>
                </ul>
            </div>
        </div>
    </section>

    