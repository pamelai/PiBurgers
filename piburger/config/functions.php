<?php

    function Section($section){
        return $_GET['section'] == $section ? 'active' : '';
    };

    function Hacer_query($query, $consulta, $cant){
        global $conexion;

        $rta=mysqli_query($conexion, $query);

        if($consulta === 'select'):
            if(mysqli_num_rows($rta) == 0):
                return false;
                
            else:
                if($cant > 1):
                    $aDatos=[];
                    while($dato=mysqli_fetch_assoc($rta)):
                        $aDatos[]=$dato;

                    endwhile;
                
                else:
                    $aDatos=mysqli_fetch_assoc($rta);

                endif;

                mysqli_free_result($rta);
                return $aDatos;
            endif;


        elseif($consulta === 'insert' || $consulta === 'update' || $consulta === 'delete'):

            return $rta;
        endif;
    }

    function Class_msj(){
        if(isset($_SESSION['ok'])):
            return 'ok';

        elseif(isset($_SESSION['error'])):
            return 'error';

        else:
            return '';

        endif;
    }
