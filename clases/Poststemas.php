<?php

namespace Clases;
require '../vendor/autoload.php';

use Clases\Conexion;
use PDOException;
use PDO;

class Poststemas extends Conexion
{
    private $id;
    private $idTag;
    private $idPost;

    public function __construct(){
        parent::__construct();
    }
    //--------------------- CRUD -------------------------------------
    public function create(){
        $c="insert into poststemas(idTag, idPost) values(:it, :ip)";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([
                ':it'=>$this->idTag,
                ':ip'=>$this->idPost
            ]);
        }catch(PDOException $ex){
            die("error al insertar en poststemas: ".$ex->getMessage());
        }
    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){

    }
    public function borrarTodo()
    {
        $con = "delete from poststemas";
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al borrar TODOs los poststemas: " . $ex->getMessage());
        }
    }
    //------------------------------------------------------------------
    public function tagsPorPost($ip){
        $c="select idTag from poststemas where idPost=:i";
        $stmt = parent::$conexion->prepare($c);
        try {
            $stmt->execute([':i'=>$ip]);
        } catch (PDOException $ex) {
            die("Error al borrar TODOs los poststemas: " . $ex->getMessage());
        }
        $cat=[];
        while($filas=$stmt->fetch(PDO::FETCH_OBJ)){
            $cat[]=$filas->idTag;
        }
        return $cat;
    }
    //-----------------------------------------------------------------------
    public function resetearCategorias(){
        $d="delete from poststemas where idPost=:ip";
        $stmt = parent::$conexion->prepare($d);
        try {
            $stmt->execute([':ip'=>$this->idPost]);
        } catch (PDOException $ex) {
            die("Error al borrar los tags de un post: " . $ex->getMessage());
        }
    }
    //-----------------------------------------------------------------

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
     * Get the value of idTag
     */ 
    public function getIdTag()
    {
        return $this->idTag;
    }

    /**
     * Set the value of idTag
     *
     * @return  self
     */ 
    public function setIdTag($idTag)
    {
        $this->idTag = $idTag;

        return $this;
    }

    /**
     * Get the value of idPost
     */ 
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set the value of idPost
     *
     * @return  self
     */ 
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;

        return $this;
    }
}