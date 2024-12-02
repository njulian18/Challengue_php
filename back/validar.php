<?php
require_once '../conexion/conexion.php';

$documento = isset($_POST['documento']) ? $_POST['documento'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$area = isset($_POST['area']) ? $_POST['area'] : '';

$sql = "SELECT COUNT(*) FROM productos WHERE documento = :documento AND area_celular = :area AND telefono = :telefono AND email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':documento', $documento);
$stmt->bindParam(':area', $area);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':email', $email);
$stmt->execute();
$usuarioExistente = $stmt->fetchColumn();


if ($usuarioExistente > 0) {
    echo 'usuario_existe';  
} elseif ($areaValida == 0) {
    echo 'area_invalida'; 
} else {
    echo 'todo_ok';
}
?>
