<?php
    require '../vendor/autoload.php';
    use Clases\Datos;
    $usu=new Datos('users', 25);
    echo "<h2>Usuarios Creados</h2>";
    $tag=new Datos('tags', 80);
    echo "<h2>Tags Creados</h2>";
    $posts=new Datos("posts", 40);
    echo "<h2>Posts Creados</h2>";