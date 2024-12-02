<?php
    include '../back/select.php';
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../plugins/dataTables/bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">

    <title>Listados!</title>
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
                    <a class="nav-link text-white active" aria-current="page" href="../index.php">Home</a>
                    <a class="nav-link text-white" href="listados.php">Listados</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center">Listado de Productos</h1>
            </div>
            <div class="card-body">
                <table id="productosTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Dni</th>
                            <th>Codigo</th>
                            <th>Tel.</th>
                            <th>Email</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
       
    </div>

    <!-- Modal Editar Producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="documento" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="documento" required>
                        </div>
                        <div class="mb-3">
                            <label for="area_celular" class="form-label">Código</label>
                            <select id="area_celular" name="area_celular" class="form-control"   required>
                                <?php
                                    foreach ($areas as $area) {
                                        echo "<option value=\"{$area['id']}\">{$area['codigo']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/dataTables/dataTables.min.js"></script>
    <script src="../plugins/dataTables/bootstrap5.min.js"></script>
    <script src="../plugins/bootstrap/bundle.min.js"></script>
    <script src="../plugins/sweet/sweetalert2.js"></script>
    <script src="../script/index.js"></script>

    

    <script>
        $(document).ready(function () {
            $('#productosTable').DataTable({
                ajax: {
                    url: '../back/datatable.php', 
                    dataSrc: 'data' 
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'apellido' },
                    { data: 'documento' },
                    { data: 'area_celular_codigo' },
                    { data: 'telefono' },
                    { data: 'email' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-outline-secondary btn-sm edit-btn" data-id="${row.id}">Editar</button>
                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="${row.id}">Eliminar</button>
                            `;
                        },
                        orderable: false, 
                        searchable: false 
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            $('#productosTable').on('click', '.delete-btn', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: `¿Estás seguro de que deseas eliminar el producto con ID: ${id}?`,
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `../back/delete.php?id=${id}`,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "¡Eliminado!",
                                    text: "Producto eliminado con éxito"
                                });
                                $('#productosTable').DataTable().ajax.reload();
                            },
                            error: function (error) {
                                console.log(error);
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Error al eliminar el producto!"
                                });
                            }
                        });
                    }
                });

            });

            $('#productosTable').on('click', '.edit-btn', function () {
                const productId = $(this).data('id');

                $.ajax({
                    url: '../back/getDatos.php', 
                    method: 'GET',
                    data: { id: productId },
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            $('#editProductId').val(response.data.id);
                            $('#nombre').val(response.data.nombre);
                            $('#apellido').val(response.data.apellido);
                            $('#documento').val(response.data.documento);
                            $('#area_celular').val(response.data.area_celular);
                            $('#telefono').val(response.data.telefono);
                            $('#email').val(response.data.email);

                            var myModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                            myModal.show();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Error al cargar los datos del producto!"
                            });
                        }
                    },
                    error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error al cargar los datos del producto!"
                    });
                    }
                });
            });

            $('#editProductForm').on('submit', function (e) {
                e.preventDefault();

                const productData = {
                    id: $('#editProductId').val(),
                    nombre: $('#nombre').val(),
                    apellido: $('#apellido').val(),
                    documento: $('#documento').val(),
                    area_celular: $('#area_celular').val(),
                    telefono: $('#telefono').val(),
                    email: $('#email').val()
                };
                console.log(productData);
                $.ajax({
                    url: '../back/update.php', 
                    method: 'POST',
                    data: productData,
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Operación Exitosa",
                            text: "Producto actualizado con éxito!"
                        });
                        var modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
                        modal.hide();
                        $('#productosTable').DataTable().ajax.reload(); 
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Error al actualizar el producto!"
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
