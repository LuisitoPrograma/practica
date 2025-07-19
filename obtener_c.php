<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/Rconexion.php');


//clientes
$sql_clientes = "
SELECT c.id AS setclienteId, c.nombre AS setclienteName, c.apellidos AS setclientesapeallidos, c.fecha_nacimiento AS setclientesfecha_nacimiento 
FROM clientes c 
WHERE c.estado = ? AND c.empresa = ? 
";
$company_id = 1;
$cliente_estado=1;
$query_clientes = mysqli_prepare($con, $sql_clientes);
mysqli_stmt_bind_param($query_clientes, 'ii', $cliente_estado,$company_id);
mysqli_stmt_execute($query_clientes);
$result_clientes = mysqli_stmt_get_result($query_clientes);

//CLIENTES
$clientes = [];
while($row_clientes = mysqli_fetch_assoc($result_clientes)){
$clientes[] = $row_clientes;
}

//clientes
$array_return = [];
$array_return['setclientes'] = $clientes;
echo json_encode($array_return)
?>