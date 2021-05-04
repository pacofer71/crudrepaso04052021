<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
    die();
}
if(!isset($_GET['id'])){
    header("Location:tags.php");
    die();
}

require '../vendor/autoload.php';
use Clases\Tags;
$id=$_GET['id'];
$esteTag=new Tags();
$esteTag->setId($id);
$estaCat=$esteTag->read();

if(isset($_POST['editar'])){
    //procesamos el form
    $cat=trim($_POST['categoria']);
    if(strlen($cat)==0){
        $_SESSION['mensaje']="Rellene el campo !!!";
        //NO olvidar pasr por get el id !!!!
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        die();
    }
    
    //el campo está bien vamos a guardarlo
    //compruebo si el usuario realmente ha cambiado la categoria
    if($estaCat==ucwords($cat)){
        $esteTag=null;
        $_SESSION['mensaje']="Tag actualizado";
        header("Location:tags.php");
        die();

    }
    
    //comprobamos antes si existe o no
    
    if(!$esteTag->existeTag(ucwords($cat))){
        $esteTag->setCategoria(ucwords($cat));
        $esteTag->update();
        $esteTag=null;
        $_SESSION['mensaje']="Tag actualizado";
        header("Location:tags.php");
    }else{
        $_SESSION['mensaje']="El tag ya existe !!!";
        $esteTag=null;
        //NO olvidar pasr por get el id !!!!
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
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
    <h3 class="text-center mt-3">Editar Tag</h3>
    <div class="container mt-3">
    <?php
        require 'resources/mensajes.php';
    ?>
    <!-- OJO hay que volver a poner en el action la variable por GET -->
    <form name="nt" action="<?php echo $_SERVER['PHP_SELF']."?id=$id"; ?>" method="POST">
    <div class="mt-2">
        <input type="text" name="categoria" value="<?php echo $estaCat; ?>" required class="form-control" />
    </div>
    <div class="mt-3">
        <input type="submit" name="editar" value="Editar" class="btn btn-success mr-2">
        <a href="tags.php" class="btn btn-primary">Volver</a>
    </div>
    
    </div>
    </form>
    </div>
</body>
</html>
<?php } ?>