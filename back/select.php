<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/challengue/conexion/conexion.php';

try {
    $query = "SELECT * FROM areas";
    $stmt = $pdo->query($query);
    $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($areas);
} catch (PDOException $e) {
    die("Error al realizar la consulta: " . $e->getMessage());
}
?>
