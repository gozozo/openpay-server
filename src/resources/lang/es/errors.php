<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Openpay Errors Lines
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    '1000' => 'Ocurrió un error interno en el servidor de Openpay',
    '1001' => 'El formato de la petición no es JSON, los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos.',
    '1002' => 'La llamada no esta autenticada o la autenticación es incorrecta.',
    '1003' => 'La operación no se pudo completar por que el valor de uno o más de los parametros no es correcto.',
    '1004' => 'Un servicio necesario para el procesamiento de la transacción no se encuentra disponible.',
    '1005' => 'Uno de los recursos requeridos no existe.',
    '1006' => 'Ya existe una transacción con el mismo ID de orden.',
    '1007' => 'La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada.',
    '1008' => 'Una de las cuentas requeridas en la petición se encuentra desactivada.',
    '1009' => 'El cuerpo de la petición es demasiado grande.',
    '1010' => 'Se esta utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se esta usando la llave privada desde JavaScript.',
    '1011' => 'Se solicita un recurso que esta marcado como eliminado.',
    '1012' => 'El monto transacción esta fuera de los limites permitidos.',
    '1013' => 'La operación no esta permitida para el recurso.',
    '1014' => 'La cuenta esta inactiva.',
    '1015' => 'No se ha obtenido respuesta de la solicitud realizada al servicio.',
    '1016' => 'El mail del comercio ya ha sido procesada.',
    '1017' => 'El gateway no se encuentra disponible en ese momento.',
    '1018' => 'El número de intentos de cargo es mayor al permitido.',
    '2001' => 'La cuenta de banco con esta CLABE ya se encuentra registrada en el cliente.',
    '2002' => 'La tarjeta con este número ya se encuentra registrada en el cliente.',
    '2003' => 'El cliente con este identificador externo (External ID) ya existe.',
    '2004' => 'El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn.',
    '2005' => 'La fecha de expiración de la tarjeta es anterior a la fecha actual.',
    '2006' => 'El código de seguridad de la tarjeta (CVV2) no fue proporcionado.',
    '2007' => 'El número de tarjeta es de prueba, solamente puede usarse en Sandbox.',
    '2008' => 'La tarjeta no es valida para puntos Santander.',
    '2009' => 'El código de seguridad de la tarjeta (CVV2) es inválido.',
    '3001' => 'La tarjeta fue declinada.',
    '3002' => 'La tarjeta ha expirado.',
    '3003' => 'La tarjeta no tiene fondos suficientes.',
    '3004' => 'La tarjeta ha sido identificada como una tarjeta robada.',
    '3005' => 'La tarjeta ha sido rechazada por el sistema antifraudes.',
    '3006' => 'La operación no esta permitida para este cliente o esta transacción.',
    '3007' => 'Deprecado. La tarjeta fue declinada.',
    '3008' => 'La tarjeta no es soportada en transacciones en línea.',
    '3009' => 'La tarjeta fue reportada como perdida.',
    '3010' => 'El banco ha restringido la tarjeta.',
    '3011' => 'El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.',
    '3012' => 'Se requiere solicitar al banco autorización para realizar este pago.',
    '4001' => 'La cuenta de Openpay no tiene fondos suficientes.',
    '4002' => 'La operación no puede ser completada hasta que sean pagadas las comisiones pendientes.',
    '5001' => 'La orden con este identificador externo (external_order_id) ya existe.',
    '6001' => 'El webhook ya ha sido procesado.',
    '6002' => 'No se ha podido conectar con el servicio de webhook.',
    '6003' => 'El servicio respondio con errores.'
];