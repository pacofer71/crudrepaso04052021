<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
        die();
    }
    if(!isset($_POST['codigo'])){
        header("Location:tags.php");
        die();
    }
    require '../vendor/autoload.php';
    use Clases\Tags;
    $esteTag=new Tags();
    $esteTag->setId($_POST['codigo']);
    $esteTag->delete();
    $esteTag=null;
    $_SESSION['mensaje']="Tag Borrado Correctamente";
    header("Location:tags.php");
