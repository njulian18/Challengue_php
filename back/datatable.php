<?php
header('Content-Type: application/json'); 
require_once '../conexion/conexion.php';

try {
    $query = "SELECT 
    productos.id, 
    productos.nombre, 
    productos.apellido, 
    productos.documento, 
    areas.codigo AS area_celular_codigo, 
    productos.telefono, 
    productos.email
FROM 
    productos
LEFT JOIN 
    areas 
ON 
    productos.area_celular = areas.id;";
    $stmt = $pdo->query($query);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $productos]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
