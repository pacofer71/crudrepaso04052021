<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
}
require '../vendor/autoload.php';
use Clases\Tags;

if(isset($_POST['crear'])){
    //procesamos el form
    $cat=trim($_POST['categoria']);
    if(strlen($cat)==0){
        $_SESSION['mensaje']="Rellene el campo !!!";
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    //el campo está bien vamos a guardarlo
    //comprobamos antes si existe o no
    $esteTag=new Tags();
    if(!$esteTag->existeTag(ucwords($cat))){
        $esteTag->setCategoria(ucwords($cat));
        $esteTag->create();
        $esteTag=null;
        $_SESSION['mensaje']="Tag creado";
        header("Location:tags.php");
    }else{
        $_SESSION['mensaje']="El tag ya existe !!!";
        $esteTag=null;
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

}
else{
    //pintamos el form
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo tag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
</head>

<body style="background-color: bisque;">
    <?php
    require 'resources/navbar.php';
    ?>
    <h3 class="text-center mt-3">Crear Tag</h3>
    <div class="container mt-3">
    <?php
        require 'resources/mensajes.php';
    ?>
    <form name="nt" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="mt-2">
        <input type="text" name="categoria" placeholder="Nueva Categoria" required class="form-control" />
    </div>
    <div class="mt-3">
        <input type="submit" name="crear" value="Crear" class="btn btn-success mr-2">
        <input type="reset" value="Limpiar" class="btn btn-warning mr-2">
        <a href="tags.php" class="btn btn-primary">Volver</a>
    </div>
    
    </div>
    </form>
    </div>
</body>
</html>
<?php } ?>