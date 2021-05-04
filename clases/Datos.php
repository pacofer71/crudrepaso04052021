<?php
    namespace Clases;
    require '../vendor/autoload.php';
    use Faker\Factory;
    use Clases\{Users, Tags, Posts, Poststemas};
    class Datos{
        public $faker;

        public function __construct($tabla, $cantidad){
            $this->faker=Factory::create('es_ES');
            switch($tabla){
                case "users":
                    $this->crearUsuarios($cantidad); 
                    break;
                case "tags": 
                    $this->crearTags();
                    break; 
                case "posts": 
                    $this->crearPost($cantidad);
                    break;       
            }
        }
        public function crearUsuarios($n){
            //creamos un usuario admin
            $usuario = new Users();
            //Borro todos los anteriores
            $usuario->borrarTodo();
            //-----------
            $usuario->setNombre("Manolo");
            $usuario->setApellidos("Gil Gil");
            $usuario->setUsername("admin");
            $usuario->setMail("admin@mail.com");
            $pass=hash('sha256', "secret0");
            $usuario->setPass($pass);
            $usuario->create();
            $usuario->setNombre("Manoli");
            $usuario->setApellidos("Gil Gil");
            $usuario->setUsername("manoli24");
            $usuario->setMail("manoli24@mail.com");
            $pass=hash('sha256', "secret0");
            $usuario->setPass($pass);
            $usuario->create();
            //creamos el resto
            for($i=0; $i<$n-1; $i++){
                $usuario->setNombre($this->faker->firstName());
                $usuario->setApellidos($this->faker->lastName(). " ". $this->faker->lastName());
                $usuario->setUsername($this->faker->unique()->userName);
                $usuario->setMail($this->faker->unique()->email);
                $usuario->setPass($this->faker->sha256);
                $usuario->create();

            }
            $usuario=null;


        }
        //--------------------------------------------
        public function crearTags(){
            $temas=['Informatica', 'Anime', 'Terror', 'Programacion', 'PHP', 'Java', 'Cine' , 'VideoJuegos', 'Moviles', 'Historia'];
            $tag=new Tags();
            $tag->borrarTodo();
            for($i=0; $i<count($temas); $i++){
                $tag->setCategoria($temas[$i]);
                $tag->create();
            }
            $tag=null;
        }
        //--------------------------------------------------------------------
        public function crearPost($n){
            //recupero en sendos arrays los id usuarios y los id tags
            $arrayUsers=(new Users())->usuariosId();
            
            $arrayTags=(new Tags())->tagsId();
            
            $estePost=new Posts();
            $estePost->borrarTodo();
            for($i=0; $i<$n; $i++){
                $estePost->setTitulo($this->faker->word());
                $estePost->setCuerpo($this->faker->text(250));
                $indice=rand(0, count($arrayUsers)-1);
                $estePost->setIdUser($arrayUsers[$indice]);
                $estePost->create();
                // ya hemos creado el POST ahora le asociaré un número
                //aleatorio de categorias
                //1.- Recupero el id del post que acabo de crear
                $idPost=Conexion::getConexion()->lastInsertId();
                $cantTags=rand(1, count($arrayTags));
                for($j=0; $j<$cantTags; $j++){
                    $postema=new Poststemas();
                    //esto no seria necesario al tener on delete cascade;
                    //$postema->borrarTodo();
                    $postema->setIdPost($idPost);
                    $postema->setIdTag($arrayTags[$j]);
                    $postema->create();
                }
                //desordeno el array de temas 
                shuffle($arrayTags);
                
            }
            $postema=null;
            $estePost=null;

            
        }
        
    }