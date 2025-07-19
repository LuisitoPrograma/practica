<?php
//CREDENCIALES BD
function db_principal(){
    $base_datos_host_db = 'practica.cfcms2w20vgk.us-west-2.rds.amazonaws.com';
    $base_datos_user_db = 'admin';
    $base_datos_clave_db = 'practicas2025';
    $base_datos_name_db= 'practica';


    return array($base_datos_host_db, $base_datos_user_db, $base_datos_clave_db, $base_datos_name_db);
    }



//DATOS DE CONEXION
$array_db_principal = db_principal();
define('DB_HOST', $array_db_principal[0]);
define('DB_USER', $array_db_principal[1]);
define('DB_PASS', $array_db_principal[2]);
define('DB_NAME', $array_db_principal[3]);

//FUNCION DE CONEXION
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//VALIDAR SI NO SE PUDO CONECTAR
if(!$con){
echo 'Imposible conectarse';
exit();
}
if(mysqli_connect_errno()){
die('Conexion fallo: '.mysqli_connect_errno().' : '. mysqli_connect_error());
exit();
}

//CHARSET DE LA CONEXION
mysqli_set_charset($con, 'utf8mb4');
