<?php
// Indicar que el contenido devuelto será JSON
header('Content-Type: application/json');

//CONEXIÓN BD
require_once(__DIR__ . '/conexion_bd.php');

// productos
$sql_productos = "
SELECT id_producto, nombre, marca, categoria, precio, stock 
FROM producto 
";

$query_productos = mysqli_prepare($con, $sql_productos);
mysqli_stmt_execute($query_productos);
$result_productos = mysqli_stmt_get_result($query_productos);

//productos
$productos = [];
while($row_productos = mysqli_fetch_assoc($result_productos)){
    $productos[] = $row_productos;
}

$array_return = [];
$array_return['setproductos'] = $productos;
echo json_encode($array_return);

mysqli_stmt_close($query_productos);
?>