<?php 
namespace haterApp\api\libs\models;
use haterApp\api\libs\Db;

class Moderados {

	private $db;

	public function __construct() {
    $db = new Db("moderados");
    $this->db = $db->getConexion();  

  }



  public function listarModerados(){
   $cursor=$this->db->find();
   $moderados = array();
   foreach ($cursor as $moderados) {
     array_push($moderados, $moderados); 
   }
   echo json_encode($moderados);
 }


 public function guardarModerados($post){

  $this->db->insert($post);
}




 public function recuperarModerado($_id){

// recuperamos un docuemnto de la collecion moderados que no haya sido ya moderado por el usuario con la id que recibimos por parametro
   $cursor= $this->db->findOne(array('usuarios_moderado' => array('$ne' =>$_id))); 

//Añadimos a ese mismo docuemnto la id del usuario que lo ha moderado en el campo "usuarios_moderado"
   $this->db->update(array("_id" =>$cursor['_id']),array('$push' => array("usuarios_moderado" => $_id)));

   $cursor = $this->db->findOne(array("_id" =>$cursor['_id']));

   return $cursor;
}
  public function moderar($votacion,$_id){
    if($votacion=="aprobar") {
    $this->db->update(array('_id' => $_id),array('$inc' => array('aprobado' =>1)));
    } else if ($votacion=="rechazar") {
    $this->db->update(array('_id' => $_id),array('$inc' => array('rechazado' =>1)));
    }
    // comprobarPublicar()
  }









}


