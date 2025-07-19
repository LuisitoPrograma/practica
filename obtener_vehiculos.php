<?php
// Indicar que el contenido devuelto será JSON
header('Content-Type: application/json');

// CONEXIÓN BD
require_once(__DIR__ . '/conexion_bd.php');

// Parámetros
$company_id = 1;
$vehiculo_estado = 1;

// Consulta SQL para vehículos
$sql_vehiculos = "
SELECT 
    v.id AS vehiculoId, 
    v.nombre AS vehiculoNombre, 
    v.marca AS vehiculoMarca, 
    v.placa AS vehiculoPlaca, 
    v.color AS vehiculoColor, 
    v.año AS vehiculoAnio, 
    v.kilometraje AS vehiculoKilometraje
FROM vehiculos v 
WHERE v.estado = ? AND v.empresa = ? 
";

// Preparar y ejecutar consulta
$query_vehiculos = mysqli_prepare($con, $sql_vehiculos);
mysqli_stmt_bind_param($query_vehiculos, 'ii', $vehiculo_estado, $company_id);
mysqli_stmt_execute($query_vehiculos);
$result_vehiculos = mysqli_stmt_get_result($query_vehiculos);

// Recoger resultados
$vehiculos = [];
while($row_vehiculos = mysqli_fetch_assoc($result_vehiculos)){
    $vehiculos[] = $row_vehiculos;
}

// Devolver JSON
$array_return = [];
$array_return['vehiculos'] = $vehiculos;
echo json_encode($array_return);
?>