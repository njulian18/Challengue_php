<?php
header('Content-Type: application/json');
require_once '../conexion/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];
    $area_celular = $_POST['area_celular'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    try {
        $query = "UPDATE productos SET 
                    nombre = :nombre, 
                    apellido = :apellido, 
                    documento = :documento, 
                    area_celular = :area_celular, 
                    telefono = :telefono, 
                    email = :email
                  WHERE id = :id";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':area_celular', $area_celular);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
