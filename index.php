<?php
    include('./back/select.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
    <title>Challengue!</title>
</head>

<body style="background-color:#EEF2FF">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Prueba Técnica PHP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link text-white active" aria-current="page" href="#">Home</a>
                    <a class="nav-link text-white" href="./pages/listados.php">Listados</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid">    
        <div class="card mt-2">
            <div class="card-header">
                Gestión de Productos
            </div>
            
            <div class="card-body">
                <div class="text-danger">
                    <p id="record"></p>   
                </div> 
                <hr>
                <div class="mt-5">
                    <form id="productForm" action="back/save.php" method="POST" class="p-4 border rounded shadow-sm" novalidate>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required
                                placeholder="Ingresa el nombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required
                                pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ' ]+" placeholder="Ingresa el apellido">
                        </div>
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento:</label>
                            <input type="text" id="documento" name="documento" class="form-control" required
                               placeholder="Ingresa el documento">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="area_celular" class="form-label">Área:</label>
                                <select id="area_celular" name="area_celular" class="form-control" required>
                                    <?php
                                    foreach ($areas as $area) {
                                        echo "<option value=\"{$area['id']}\">{$area['codigo']}</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" required
                                    pattern="\d{8,}" minlength="8" placeholder="Número de teléfono">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required
                                placeholder="ejemplo@dominio.com">
                        </div>
                        <div class="text-center">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-success btn-large">Guardar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>


    <script src="./plugins/bootstrap/bundle.min.js"></script>
    <script src="./plugins/jquery/jquery.min.js"></script>
    <script src="./plugins/sweet/sweetalert2.js"></script></script>
    <script>
        function validarCampo(input, pattern, mensajeError) {
            if (!pattern.test(input.value)) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: mensajeError
                });
                input.focus();
                return false; 
            }
            return true; 
        }

        function validarCorreo(email) {
            const emailPattern = /^[a-z0-9]([a-z0-9._-]*[a-z0-9])?@[a-z0-9-]+\.[a-z0-9-]{2,3}(\.[a-z0-9-]{2,3})?$/;
            // Verificar si contiene solo un `@`
            if ((email.match(/@/g) || []).length !== 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Correo no válido',
                    text: "El correo debe contener exactamente un símbolo '@'."
                });
                return false;
            }
                //  Verificar nombre de usuario
                const nombreUsuarioPattern = /^[a-z0-9]([a-z0-9._-]*[a-z0-9])?$/;
                const nombreUsuario = email.split('@')[0];
                if (!nombreUsuarioPattern.test(nombreUsuario)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Correo no válido',
                        html: `
                            <ul class="text-right">
                                <li>El nombre de usuario solo puede contener:</li>
                                <li>letras latinas (a-z)</li>
                                <li>números (0-9)</li>
                                <li>guiones bajos (_)</li>
                                <li>puntos (.)</li>
                                <li>guiones (-)</li>
                                <li>No puede empezar ni terminar con un punto (.)</li>
                                <li>No puede tener puntos consecutivos</li>
                            </ul>
                        `
                    });
                    return false;
                }
                //  Verificar dominio
                const dominioPattern = /^[a-z0-9-]+\.[a-z0-9-]{2,3}(\.[a-z0-9-]{2,3})?$/;
                const dominio = email.split('@')[1];
                if (!dominioPattern.test(dominio)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Correo no válido',
                        text: "El dominio del correo debe ser válido y debe tener entre 2 y 3 caracteres en la última parte."
                    });
                    return false;
            }
                return true;
        }
        function validarUnico(documento,area,telefono,email){
            $.ajax({
                url: './back/validar.php', 
                type: 'POST',
                data: {
                    documento: documento,
                    area: area,
                    telefono: telefono,
                    email: email,
                },
                success: function(response) {
                    if (response === 'usuario_existe') {
                        $('#record').html('Ya existe un usuario con la misma combinación de documento, teléfono y email.');
                    } else if (response === 'area_invalida') {
                        $('#record').html('El área no es válida.');
                    } else if (response === 'todo_ok') {
                        // Si la validación es exitosa, podemos enviar el formulario
                        $('#record').html('Los datos son válidos. El formulario puede enviarse.');
                        document.getElementById('productForm').submit();
                    }
                },
                error: function() {
                    $('#record').html('Hubo un error al procesar la solicitud.');
                }
            });

        }

        document.getElementById('productForm').addEventListener('submit', function (e) {
            e.preventDefault();  
            const nombreInput = document.getElementById('nombre');
            const apellidoInput = document.getElementById('apellido');
            const documentoInput = document.getElementById('documento');
            const areaInput = document.getElementById('area_celular').value;
            const telefonoInput = document.getElementById('telefono');
            const emailInput = document.getElementById('email');
                  emailInput.value = emailInput.value.toLowerCase();
            // Patrones
            const namePattern = /^[A-Za-zÁÉÍÓÚáéíóúñÑ' ]+$/;
            const documentoPattern = /^\d{1,10}$/; 
            const telefonoPattern = /^\d{8,10}$/; 

            if (!validarCampo(nombreInput, namePattern, "El nombre solo puede contener letras, espacios, acentos y la letra ñ.")) {
 
                return;
            }

            if (!validarCampo(apellidoInput, namePattern, "El apellido solo puede contener letras, espacios, acentos y la letra ñ.")) {
                return;
            }

            if (!validarCampo(documentoInput, documentoPattern, "El documento debe contener solo números y un máximo de 10 dígitos.")) {
                return;
            }
            if (!validarCampo(telefonoInput, telefonoPattern, "El Telefono debe contener solo números entre 8 y 10 dígitos.")) {
                return;
            }
            if (!validarCorreo(emailInput.value)) {
                return;
            }
            validarUnico(documentoInput.value,areaInput,telefonoInput.value,emailInput.value)
        });
    </script>
</body>

</html>