<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
        die();

    }
    if(!isset($_GET['id'])){
        header("Location:posts.php");
        die();
    }
    require '../vendor/autoload.php';
    use Clases\Posts;
    $cod=$_GET['id'];
    $estePost=new Posts();
    $estePost->setId($cod);
    $datos=$estePost->read();
    $fila1=$datos->fetch(PDO::FETCH_OBJ);
    $estePost=null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
</head>

<body style="background-color: bisque;">
    <?php
    require 'resources/navbar.php';
?>
    <h3 class="text-center mt-3">Detalle Post (<?php echo $fila1->id?>)</h3>
    <div class="container mt-3">
        <div class="card m-auto" style="width: 54rem;">
            <div class="card-body">
                <h5 class="card-title text-center"><?php echo $fila1->titulo; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><b>Autor:</b>
                    <?php 
echo "<a href='postsusuario.php?un={$fila1->username}'>#{$fila1->username}</a> ({$fila1->apellidos}, {$fila1->nombre})"; ?></h6>
                <p class="card-text test-justify"><?php echo $fila1->cuerpo; ?></p>
                <p class='mt-2'><b>Fecha Creación:</b> <?php echo $fila1->fecha; ?></p>
                <a href="postscategoria.php?cat=<?php echo $fila1->categoria;?>" class="card-link"><?php echo "#".$fila1->categoria; ?></a>
                <?php 
        while($fila=$datos->fetch(PDO::FETCH_OBJ)){
            echo "<a href='postscategoria.php?cat={$fila->categoria}' class='card-link'>#{$fila->categoria}</a>";
        }
        ?>
            </div>
        </div>
    </div>
    <div class='mt-3 text-center'>
    <a href="javascript:history.back(-1);" class='btn btn-secondary'>Volver</a>
    </div>
</body>

</html>