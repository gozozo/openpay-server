# openpay-server

Implementación de los servicios de Openpay 

##Instalación

Ejecutar el siguiente comando

> composer require gozozo/openpay-server 

Después agregar la siguiente línea  en `**provider**` en el archivo que se encuentra en `**config/app.php**`

`Gozozo\OpenpayServer\OpenpayServerServiceProvider::class,`

y luego ejecutamos los siguintes comandos

`php artisan vendor:publish --provider="Gozozo\OpenpayServer\OpenpayServerServiceProvider"`
`php artisan migrate`

##Configuración de .env
###Configurar middleware 

Permite una autenticación antes de acceder alas rutas

`OPENPAY_MIDDLEWARE=Nombre_middleware`

###Llaves del API de Openpay

Configuración de las llaves 

`OPENPAY_ID = Id_de_pruebas`
`OPENPAY_SK = Llave_privada_pruebas`
`OPENPAY_ID_PRODUCTION = Id_producción`
`OPENPAY_SK_PRODUCTION = Llave_privada_producción`

###Tabla de referencia

Relación de la tabla de referencia openpay con tu tabla de usuarios 

`OPENPAY_TABLE = Tabla_usuario`
`OPENPAY_REFERENCE = Id_tabla_usuario`
