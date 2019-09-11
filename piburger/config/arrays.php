<?php
$aNav=[];
$aNav=[
    [
    'nombre'=>'Inicio',
    'href'=>'index.php?section=home',
    'class'=>'home'
    ],
    [
    'nombre'=>'Menú',
    'href'=>'index.php?section=menu',
    'class'=>'menu'
    ],
    [
    'nombre'=>'Contacto',
    'href'=>'index.php?section=contacto',
    'class'=>'contacto'
    ]
];

$aSesion=[
    [
    'nombre'=>'Registro',
    'href'=>'index.php?section=registro',
    'class'=>'registro'
    ],
    [
    'nombre'=>'Log-in',
    'href'=>'index.php?section=login',
    'class'=>'login'
    ]
];

$aLogeado=[
    [
    'nombre'=>'Perfil',
    'href'=>'index.php?section=perfil',
    'class'=>'perfil'
    ],
    [
    'nombre'=>'Log-out',
    'href'=>'logout.php',
    'class'=>'logout'
    ]
];

$aErrores=[
    'email'=> 'Por favor, ingrese un email',
    'motivo'=> 'Por favor, seleccione el motivo',
    'comentario'=> 'Por favor, ingrese el comentario',
    'user'=> 'Por favor, ingrese el nombre de usuario',
    'pass'=> 'Por favor, ingrese una contraseña',
    'pass_conf'=> 'Por favor, confirme la contraseña',
    'email_conf'=> 'Por favor, confirme el e-mail',
    'pass_nocoincide' => 'Las contraseñas no coinciden',
    'email_nocoincide' => 'Los e-mails no coinciden',
    'registro' => 'No se pudieron registrar sus datos, intentelo nuevamente',
    'user_login' => 'Ingrese usuario o e-mail',
    'pass_login' => 'Ingrese una contraseña',
    'user_incorrecto' => 'Usuario o contraseña incorrectos',
    'rol' => 'Por favor, ingrese el rol del usuario',
    'agregar_db' => 'No se pudo agregar los datos',
    'update_db' => 'No se pudieron actualizar los datos',
    'denegado' => 'No tienes permisos para acceder a la sección',
    'user_existe' => 'Nombre de usuario ya existente',
    'email_existe' => 'El e-mail ya está en uso',
    'stars' => 'Por favor, ingrese una puntuación',
    'review' => 'No se pudo publicar la review',
    'comments' => 'Si querés dejar tu review primero debés logearte',
    'eliminar' => 'No se pudo eliminar al usuario.',
    'type_img' => 'Tipo de imagen incorrecto. Solo png y jpeg',
    'nombre' => 'Por favor, ingrese el nombre del plato',
    'tipo' => 'Por favor, ingrese el tipo',
    'desc' => 'Por favor, ingrese la decripción del plato',
    'img' => 'Por favor, ingrese la imagen del plato',
    'nombre_existe' => 'Nombre de plato ya existente',
    'img_existe' => 'La imagen seleccionada ya está en uso',
    'plato_vacio' => 'Por favor, elija un plato',
    'plato_doble' => 'Solo puede elejir un plato a la vez',
    'adicional' => 'El adicional no está disponible para este plato',
    'cant' => 'Por favor, indique la cantidad deseada de este producto',
    'pedido' => 'Hubo un error al agregar tu pedido',
    'domicilio' => 'Por favor, seleccione un domicilio',
    'calle' => 'Por favor, ingrese el nombre de la calle',
    'nro' => 'Por favor, ingrese la altura',
    'ciudad' => 'Por favor, ingrese la ciudad',
    'prov' => 'Por favor, ingrese la provincia',
    'prov_error' => 'La provincia seleccionada no corresponde con la ciudad',
    'tel' => 'Por favor, ingrese número de teléfono',
    'tel_db' => 'Por favor, seleccione un número de teléfono',
    'tel_alter' => 'Por favor, ingrese un número de contacto',
    'tc' => 'Por favor, seleccione una tarjeta',
    'metodo' => 'Por favor, seleccione un método de pago',
    'titular' => 'Por favor, ingrese el nombre del titular',
    'nro_tar' => 'Por favor, ingrese el número de la tarjeta',
    'nro_tar_erroneo' => 'Por favor, ingrese un número de tarjeta válido',
    'vencimiento' => 'Por favor, ingrese mes y año de vencimiento',
    'cvv' => 'Por favor, ingrese el cvv',
    'cvv_american' => 'CVV incorrecto. Ingrese el código de 4 cifras',
    'cvv_error' => 'CVV incorrecto. Ingrese el código de 3 cifras',
    'clave' => 'Por favor, ingrese su clave',
    'guardar_domicilio' => 'No se pudo guardar el domicilio',
    'guardar_tel' => 'No se pudo guardar el teléfono',
    'guardar_tc' => 'No se pudieron guardar los datos de la tarjeta',
    'checkout' => 'Hubo un error a la hora de finalizar el pedido',
    'eliminar_plato' => 'Hubo un error al eliminar el plato',
    'anular' => 'Hubo un error al anular el pedido',
    'estado' => 'Hubo un error actualizar el estado del pedido',
    'precio' => 'Por favor, ingrese el valor del producto'
    
];

$aOks=[
    'enviado' => '¡Gracias! El mensaje ha sido enviado',
    'registro' => '¡Gracias por registrarte! Ya puedes ingresar a tu cuenta',
    'agregar_db' => 'Los datos han sido agregados correctamente',
    'update_db' => 'Los datos se actualizaron correctamente',
    'review' => 'La review se publicó correctamente',
    'eliminar' => 'El dato ha sido eliminado correctamente',
    'combo' => 'Tu pedido se agregó correctamente',
    'checkout' => 'El pedido se realizó con éxito. Chequeá el estado del mismo en "Seguimiento"',
    'eliminar_plato' => 'El plato se eliminó con éxito',
    'anular' => 'El pedido se anuló con éxito',
    'estado' => 'El pedido se actualizó correctamente'
];

$aType_img=['image/png','image/jpeg'];