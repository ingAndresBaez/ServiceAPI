<?php

define('DB_HOST','bqyeurzfuixip8ywgozv-mysql.services.clever-cloud.com');
define('DB_USER','uas9vncpbm6rs7kf');
define('DB_PASSWORD','NeBTBOulnu3ZwTKv5V7s');
define('DB_DATABASE','bqyeurzfuixip8ywgozv');

function connectionDB(){
    $connection = new mysqli(DB_HOST,  DB_USER, DB_PASSWORD, DB_DATABASE);
    if($connection->connect_error){
        // Registrar el error en un archivo de log
        error_log("Conexión fallida: " . $connection->connect_error);
        // Mostrar un mensaje genérico al usuario
        die("Conexión a la base de datos fallida. Por favor, inténtelo de nuevo más tarde.");
    }
    return $connection;
}
