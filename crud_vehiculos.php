<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/conexion_bd.php');

$method = $_SERVER['REQUEST_METHOD'];
$company_id = 1; // ID de la empresa

switch ($method) {
    case 'GET':
        // Obtener todos los vehículos
        $sql = "SELECT id, nombre, marca, placa, color, año, kilometraje FROM vehiculos WHERE estado = 1 AND empresa = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $company_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $vehiculos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $vehiculos[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $vehiculos]);
        break;
        
    case 'POST':
        // Crear o actualizar vehículo
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id'])) {
            // Actualizar vehículo existente
            $sql = "UPDATE vehiculos SET nombre = ?, marca = ?, placa = ?, color = ?, año = ?, kilometraje = ? WHERE id = ? AND empresa = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssidii', $data['nombre'], $data['marca'], $data['placa'], $data['color'], $data['año'], $data['kilometraje'], $data['id'], $company_id);
        } else {
            // Crear nuevo vehículo
            $sql = "INSERT INTO vehiculos (nombre, marca, placa, color, año, kilometraje, estado, empresa) VALUES (?, ?, ?, ?, ?, ?, 1, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssidi', $data['nombre'], $data['marca'], $data['placa'], $data['color'], $data['año'], $data['kilometraje'], $company_id);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
        }
        break;
        
    case 'DELETE':
        // Eliminar vehículo (borrado lógico)
        $id = $_GET['id'];
        $sql = "UPDATE vehiculos SET estado = 0 WHERE id = ? AND empresa = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $id, $company_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
        break;
}
?>