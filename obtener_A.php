<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/Rconexion.php');


// Consulta para obtener todos los alumnos
$sql_alumnos = "
SELECT 
    a.id AS setalumnoId,
    a.nombres AS setalumnoNombre,
    a.apellidos AS setalumnoApellidos,
    a.fecha_nacimiento AS setalumnoFechaNacimiento,
    a.edad AS setalumnoEdad,
    a.escuela AS setalumnoEscuela,
    a.ciclo AS setalumnoCiclo,
    a.correo AS setalumnoCorreo,
    a.telefono AS setalumnoTelefono,
    a.direccion AS setalumnoDireccion,
    a.creado_en AS setalumnoCreado
FROM alumnos a
";

// Preparar y ejecutar consulta (sin parámetros porque no hay WHERE)
$query_alumnos = mysqli_prepare($con, $sql_alumnos);
mysqli_stmt_execute($query_alumnos);
$result_alumnos = mysqli_stmt_get_result($query_alumnos);

// Alumnos
$alumnos = [];
while($row_alumno = mysqli_fetch_assoc($result_alumnos)) {
    $alumnos[] = $row_alumno;
}

// Retornar JSON
$array_return = [];
$array_return['setalumnos'] = $alumnos;

echo json_encode($array_return);
?>
