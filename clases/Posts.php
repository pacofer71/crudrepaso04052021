<?php

namespace Clases;
require '../vendor/autoload.php';
use Clases\Conexion;
use PDOException;
use PDO;
class Posts extends Conexion{
    private $id;
    private $titulo;
    private $cuerpo;
    private $idUser;
    private $fecha;

    public function __construct(){
        parent::__construct();
    }

    //----------------- CRUD -------------------------------------
    public function create(){
        $c="insert into posts(titulo, cuerpo, idUser, fecha) values(:t, :c, :iu, now())";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([
                ':t'=>$this->titulo,
                ':c'=>$this->cuerpo,
                'iu'=>$this->idUser
            ]);
        }catch(PDOException $ex){
            die("error al insertar en posts: ".$ex->getMessage());
        }
    }
    public function read(){
        $c="select distinct posts.*, username, nombre, apellidos, categoria
        from posts, users, tags, poststemas where users.id=posts.idUser AND
         posts.id=poststemas.idPost AND poststemas.idTag=tags.id AND
          posts.id=:i";
          $stmt=parent::$conexion->prepare($c);
          try{
              $stmt->execute([
                  ':i'=>$this->id
              ]);
          }catch(PDOException $ex){
              die("error al insertar en posts: ".$ex->getMessage());
          }
          return $stmt;
    }
    public function update(){
        $u="update posts set titulo=:t, cuerpo=:c where id=:i";
        $stmt=parent::$conexion->prepare($u);
          try{
              $stmt->execute([
                  ':i'=>$this->id,
                  ':t'=>$this->titulo,
                  ':c'=>$this->cuerpo
              ]);
          }catch(PDOException $ex){
              die("error al actualizar posts: ".$ex->getMessage());
          }

    }

    public function delete(){
        $d="delete from posts where id=:i";
        $stmt=parent::$conexion->prepare($d);
          try{
              $stmt->execute([
                  ':i'=>$this->id
              ]);
          }catch(PDOException $ex){
            die("error en el metodo delete post: ".$ex->getMessage());      
        }
    }
    public function borrarTodo()
    {
        $con = "delete from posts";
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al borrar TODOs los posts: " . $ex->getMessage());
        }
    }
    public function devolverTodo(){
        $con = "select posts.*, username from posts, users 
        where posts.idUser=users.id order by username, titulo";
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al borrar TODOs los posts: " . $ex->getMessage());
        }
        return $stmt;
    }
    public function devolverPost(){
        $con = "select * from posts where id=:i"; 
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute([':i'=>$this->id]);
        } catch (PDOException $ex) {
            die("Error al borrar TODOs los posts: " . $ex->getMessage());
        }
        return ($stmt->fetch(PDO::FETCH_OBJ));
    }
    //----------------------------------------------
    public function devolverPorCategoria($cat){
        $con = "select distinct posts.*, username from posts, users, tags, poststemas
         where posts.idUser=users.id AND posts.id=poststemas.idPost AND 
          tags.id=poststemas.idTag AND categoria=:c";
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute([':c'=>$cat]);
        } catch (PDOException $ex) {
            die("Error al devolver post por categoria: " . $ex->getMessage());
        }
        return $stmt;
    }
    public function devolverPorUsuario($un){
        $con = "select distinct posts.*, username from posts, users, tags, poststemas
         where posts.idUser=users.id AND posts.id=poststemas.idPost AND 
          tags.id=poststemas.idTag AND username=:un";
        $stmt = parent::$conexion->prepare($con);
        try {
            $stmt->execute([':un'=>$un]);
        } catch (PDOException $ex) {
            die("Error al devolver post por usuario: " . $ex->getMessage());
        }
        return $stmt;
    }


    //----------------------------------------------------------------
    

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
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of cuerpo
     */ 
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set the value of cuerpo
     *
     * @return  self
     */ 
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }
}