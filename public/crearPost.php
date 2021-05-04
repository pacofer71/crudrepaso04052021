<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:login.php");
}
require '../vendor/autoload.php';
use Clases\{Conexion, Posts, Tags, Poststemas, Users};
$cat=new Tags();
$todas=$cat->devolverTodos();
$cat=null;
function errores($texto){
    $_SESSION['mensaje']=$texto;
    header("Location:{$_SERVER['PHP_SELF']}");
    die();
}
if(isset($_POST['crear'])){
  //1.- recupero el id del usuario con el que estoy logueado a partir de su nombre
    $usuario=new Users();
    $idU=$usuario->devolverIdUser($_SESSION['username']);
    $usuario=null;
  //2.- recupero y limipo titulo y cuerpo
  $titulo=ucwords(trim($_POST['titulo']));
  $contenido=ucfirst(trim($_POST['cuerpo']));
  if(strlen($titulo)==0 || strlen($contenido)==0){
      errores("Rellene título y contenido");
  }
  //3.- compruebo que al menos he elegido una categoria
  if(!is_array($_POST['categorias'])){
      errores("Seleccione al menos una categoría");
  }

  //4.- guardo el post (tit, cuerpo, idU)
  $nuevoPost=new Posts();
  $nuevoPost->setTitulo($titulo);
  $nuevoPost->setCuerpo($contenido);
  $nuevoPost->setIdUser($idU);
  $nuevoPost->create();
  //5.- Ahora con el post creado le iremos añadiendo las etiquetas
  //    seleccionadas (al menos hemos obligado a que haya una)
  $id_Post=Conexion::getConexion()->lastInsertId();
  //die($id_Post);

  // recorremos las categorias seleccionadas
  $pt=new Poststemas();
  $pt->setIdPost($id_Post);
  foreach($_POST['categorias'] as $k=>$v){
    $pt->setIdTag($v);
    $pt->create();
  }
  $nuevoPost=null;
  $pt=null;
  $_SESSION['mensaje']="Post creado";
  header("Location:posts.php");

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
    <h3 class="text-center mt-3">Crear Post</h3>
    <div class="container mt-3">
    <?php
        require 'resources/mensajes.php';
    ?>
    <form name="nt" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="mt-2">
        <input type="text" name="titulo" placeholder="Pon el título" required class="form-control" />
    </div>
    <div class="mt-2">
    <textarea class="form-control" placeholder="Contenido del Post" name="cuerpo" required></textarea>
    </div>
    <div class="mt-2">
    <ul>
    <?php
        while($item=$todas->fetch(PDO::FETCH_OBJ)){
        echo <<< CADENA
        <li>
            <input type="checkbox" name='categorias[]' value='{$item->id}' />&nbsp;{$item->categoria}
        </li>\n
        CADENA;
        }
    ?>
    </ul>
    </div>
    <div class="mt-2">
        <input type="submit" name="crear" value="Crear" class="btn btn-success mr-2">
        <input type="reset" value="Limpiar" class="btn btn-warning mr-2">
        <a href="posts.php" class="btn btn-primary">Volver</a>
    </div>
    
    </div>
    </form>
    </div>
</body>
</html>
<?php } ?>