<?php
header('Content-Type: application/json');
require_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = intval($_GET['id']);
    
    if ($id) {
        try {
            $query = "DELETE FROM productos WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se encontró el producto']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
