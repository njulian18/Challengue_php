Objetivo:

1- Descargar el proyecto y ubicarlo en la carpeta htdocs de XAMPP.
2- Configurar el archivo conexion/conexion.php con los datos de tu base de datos.

A continuación, ejecuta las siguientes consultas para la creación de las tablas:

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    documento VARCHAR(10) NOT NULL UNIQUE,
    area_celular VARCHAR(3) NOT NULL,
    telefono VARCHAR(8) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE
);


CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(3) UNIQUE NOT NULL
);


INSERT INTO areas (codigo) VALUES ('011'), ('035'), ('223'), ('261'),('012'), ('036'), ('224'), ('262'),('013'), ('037');





Creación

![imagen](https://github.com/user-attachments/assets/f87a2c4c-151f-4d2c-bbfb-ff730386dfd5)


Listado 

![imagen](https://github.com/user-attachments/assets/72e4fed1-ff46-4ff8-9861-2931293310de)





===========

Aquí tienes un resumen claro y conciso de los puntos que puedes agregar a tu archivo README en GitHub:

Resumen de la Prueba Técnica PHP

Objetivo:
Construir una aplicación full-stack para un formulario online que permita realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en productos. La aplicación incluirá un frontend (HTML, CSS, JavaScript) y un backend utilizando PHP, con una base de datos MySQL.
Requisitos:

    Formulario de Registro de Productos:
        Campos:
            Nombre: Letras (a-z, A-Z), letras acentuadas, ñ, apóstrofes. Formato de mayúsculas/minúsculas.
            Apellido: Igual que el campo Nombre.
            Documento: Solo números, máximo 10 caracteres.
            Teléfono celular: Dos campos:
                Área: 3 números, validado contra la tabla área.
                Teléfono: Mínimo 8 números.
            Email: Debe tener un solo "@" y seguir el formato de correo electrónico. Se valida:
                Nombre de usuario: solo letras (a-z), números (0-9), y caracteres especiales: guiones bajos (_), puntos (.), y guiones (-). No debe empezar o terminar con punto ni tener puntos consecutivos.
                Dominio: solo letras latinas y números, separadas por puntos, con la última parte de 2 a 3 caracteres.

    Validaciones:
        El formulario debe validar que el área exista en la tabla de áreas y que los valores de documento, teléfono y email sean únicos.

    Base de Datos:
        Tabla Área: Columna codigo_area (int, 3 caracteres), generando 10 números aleatorios.
        Tabla Formulario: Almacenar los datos ingresados en el formulario.

    Funcionalidades:
        El usuario debe poder completar el formulario con validación de los datos, asegurando la unicidad de los valores.
        El sistema debe permitir listar los registros de la base de datos con opciones para editar y eliminar.

