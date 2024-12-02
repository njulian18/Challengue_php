<?php
    require_once '../conexion/conexion.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
        $documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
        $area = filter_input(INPUT_POST, 'area_celular', FILTER_SANITIZE_STRING);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    
        if ($nombre && $apellido && $documento && $area && $telefono && $email) {
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, apellido, documento, area_celular, telefono, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $apellido, $documento, $area, $telefono, $email]);
            header('Location: ../index.php');
        } else {
            echo "Datos inválidos.";
        }
    }