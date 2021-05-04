<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
}
require '../vendor/autoload.php';

use Clases\Tags;

$tags = new Tags();
$mistags = $tags->devolverTodos();
$tags = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
</head>

<body style="background-color: bisque;">
    <?php
    require 'resources/navbar.php';
    ?>
    <h3 class="text-center mt-3">Gestionar Tags</h3>
    <div class="container mt-3">
    <?php
        require 'resources/mensajes.php';
    ?>
    <a href="crearTag.php" class='btn btn-primary my-3'>Nuevo tag</a>
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $mistags->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>\n";
                    echo "<th scope='row'>{$fila->id}</th>";
                    echo "<td>{$fila->categoria}</td>";
                    echo "<td>\n";
echo "<form name='as' method='POST' class='form-inline' action='borrarTag.php'>\n";
echo "<a href='editarTag.php?id={$fila->id}' class='btn btn-warning'>Editar</a>&nbsp;\n";
echo "<input type='hidden' name='codigo' value='{$fila->id}'>\n";
echo "<button type='submit' class='ml-2 btn btn-danger'>Borrar</button>\n";
echo "</form>\n";
                    echo"</td>\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>