<?php

namespace Clases;
//require '../vendor/autoload.php';
use Clases\Conexion;
use PDOException;
use PDO;
class Tags extends Conexion{
    private $id;
    private $categoria;

    public function __construct(){
        parent::__construct();
    }
    //----------   CRUD  ------------------------------
    public function create(){
        $i="insert into tags(categoria) values(:c)";
        $stmt=parent::$conexion->prepare($i);
        try{
            $stmt->execute([':c'=>$this->categoria]);
        }catch(PDOException $ex){
            die("Error al insertar un tag: ". $ex->getMessage());
        }

    }
    public function read(){
        $c="select * from tags where id=:i";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([
                ':i'=>$this->id
            ]);
        }catch(PDOException $ex){
            die("Error al devolver un tags: ". $ex->getMessage());
        }
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
        return $fila->categoria;

    }
    public function update(){
        $u="update tags  set categoria=:c where id=:i";
        $stmt=parent::$conexion->prepare($u);
        try{
            $stmt->execute([
                ':i'=>$this->id,
                ':c'=>$this->categoria
            ]);
        }catch(PDOException $ex){
            die("Error al editar un tags: ". $ex->getMessage());
        }

    }
    public function delete(){
        $c="delete from tags where id=:i";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([
                ':i'=>$this->id
            ]);
        }catch(PDOException $ex){
            die("Error al borrar un tags: ". $ex->getMessage());
        }
    }
    public function borrarTodo(){
        $c="delete from tags";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al borrar todos los tags: ". $ex->getMessage());
        }

    }
    public function devolverTodos(){
        $c="select * from tags order by categoria";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al devolver todos los tags: ". $ex->getMessage());
        }
        return $stmt;
    }
    //método para ver si un tag existe
    public function existeTag($tag){
        $c="select * from tags where categoria=:c";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([
                ':c'=>$tag
            ]);
        }catch(PDOException $ex){
            die("Error al comprobar existencia tag: ". $ex->getMessage());
        }
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
        return ($fila==null) ? false : true;

    }
    //-------------------------------------------------------
    public function tagsId(){
        $c="select id from tags";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error extrar id tags: " . $ex->getMessage());
        }
        $idTags=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $idTags[]=$fila->id;
        }
        return $idTags;

    }
    //-----------------------------------------------------

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }
}