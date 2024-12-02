<?php
header('Content-Type: application/json'); 

require_once '../conexion/conexion.php'; 
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        $query = "SELECT id, nombre, apellido, documento, area_celular, telefono, email FROM productos WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo json_encode(['success' => true, 'data' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
?>
