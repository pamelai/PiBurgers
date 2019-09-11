<div id='registro' class="encabezado">
    <h2>Registrarse</h2>
</div>

<section>
    <div class='error'>
        <?= isset($_SESSION['error']) && $_SESSION['error']=== 'registro' ? $aErrores['registro'] : ''; ?>
    </div>

    <form action="registrar.php" method='post'>
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre" value='<?= isset($_SESSION['datos']['nombre']) ? $_SESSION['datos']['nombre'] : ''; ?>'>
        </div>

        <div>
            <label>Apellido</label>
            <input type="text" name="apellido" value='<?= isset($_SESSION['datos']['apellido']) ? $_SESSION['datos']['apellido'] : ''; ?>'>
        </div>

        <div>
            <label>Usuario <span>*</span></label>
            <input type="text" name="user" value='<?= isset($_SESSION['datos']['user']) ? $_SESSION['datos']['user'] : ''; ?>'>
            <div class='error'>
                <?php
                    if(isset($_SESSION['error']) && $_SESSION['error']==='user'):
                        echo $aErrores['user'];

                    elseif(isset($_SESSION['error']) && $_SESSION['error']==='user_existe'):
                        echo $aErrores['user_existe'];

                    endif;  
                ?>
            </div>
        </div>

        <div>
            <label>Contraseña <span>*</span></label>
            <input type="password" name="pass">
            <div class='error'>
                <?=
                    isset($_SESSION['error']) && $_SESSION['error']=== 'pass' ? $aErrores['pass'] : '';
                ?>
            </div>
        </div>

        <div>
            <label>Confirmar contraseña <span>*</span></label>
            <input type="password" name="pass_conf">
            <div class='error'>
                <?php
                    if(isset($_SESSION['error']) && $_SESSION['error'] === 'pass_conf'):
                        echo $aErrores['pass_conf'];

                    elseif(isset($_SESSION['error']) && $_SESSION['error'] === 'pass_nocoincide'):
                        echo $aErrores['pass_nocoincide'];

                    endif;
                ?>
            </div>
        </div>

        <div>
            <label>E-mail <span>*</span></label>
            <input type="email" name="email" value='<?= isset($_SESSION['datos']['email']) ? $_SESSION['datos']['email'] : ''; ?>'>
            <div class='error'>
                <?php
                    if(isset($_SESSION['error']) && $_SESSION['error']==='email'):
                        echo $aErrores['email'];

                    elseif(isset($_SESSION['error']) && $_SESSION['error']==='email_existe'):
                        echo $aErrores['email_existe'];

                    endif;  
                ?>
            </div>
        </div>

        <div>
            <label>Confirmar e-mail <span>*</span></label>
            <input type="email" name="email_conf">
            <div class='error'>
                <?php
                    if(isset($_SESSION['error']) && $_SESSION['error'] === 'email_conf'):
                        echo $aErrores['email_conf'];

                    elseif(isset($_SESSION['error']) && $_SESSION['error']=== 'email_nocoincide'):
                        echo $aErrores['email_nocoincide'];

                    endif;
                ?>
            </div>
        </div>
        <input type="submit" value="Registrarse">
    </form>
</section>