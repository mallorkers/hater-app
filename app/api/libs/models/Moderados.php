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


 public function saveModerados($post){

  $this->db->insert($post);
}




}


