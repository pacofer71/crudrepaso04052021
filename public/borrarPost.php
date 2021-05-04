<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
        die();
    }
    if(!isset($_POST['codigo'])){
        header("Location:posts.php");
        die();
    }
    require '../vendor/autoload.php';
    use Clases\Posts;
    $estePost=new Posts();
    $estePost->setId($_POST['codigo']);
    $estePost->delete();
    $estePost=null;
    $_SESSION['mensaje']="Post Borrado Correctamente";
    header("Location:posts.php");
