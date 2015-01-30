<?php
namespace haterApp\libs\models;
use haterApp\libs\Db;
use Rhumsaa\Uuid\Uuid;
use haterApp\libs;
  class Usuarios {

  	private $db;

  	public function __construct() {
      $db = new Db("usuarios");
      $this->db = $db->getConexion();  
    }

    public function guardarUsuario($usuario){
    	$hash = new Hasher;
  		
  		$usuario = array(  
        "_id" => Uuid::uuid4()->toString(),
        "usuario" => $usuario->usuario,
        "email"  => $input->sexo,
        "pass" =>  $hash->create_hash_blowfish($pass);
        'fecha_registro' => new \MongoDate(),
        "publicaciones" => [],
        "comentarios" => []     
        );

        $this->db->insert($usuario);
} 

	    public function userExistsEmail($email,$collection){
        try{
            $con= DB::connect();
            $collection = $con->cups->$collection;
            $cursor= $collection->find(array('email' => $email));
            if ($cursor->count()!=0) return true;
            else return false;
        } catch (MongoConnectionException $e){
            die($e->getMessage());}
    }


    /**
 * Comprueba si un usuario existe por su email.
 * @param $email Email del usuarios a comprobar.
 * @param $collection Coleciión en la que buscar
 * @return bool True si el usuario existe, false en caso contrario.
 */
     public function userExistsId($id,$collection){
        try{
            $con= DB::connect();
            $collection = $con->cups->$collection;
            $cursor= $collection->find(array('_id' => $id));
            if ($cursor->count()!=0) return true;
            else return false;
        } catch (MongoConnectionException $e){
            die($e->getMessage());}
    }

        /**Obtiene un usuario por su ID.
     * @param $id ID del usuario.
     * @return array
     */
    public function getUser($id){
        $con= DB::connect();
        $collection = $con->cups->users;
        $cursor=$collection->find(array('_id' => $id)); //

         if ($cursor->count()!=0) {
             return $cursor->getNext();
         }
}

}
