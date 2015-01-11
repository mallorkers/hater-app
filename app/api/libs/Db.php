<?php
namespace haterApp\api\libs;

class Db {
 
 private $db;

 public function __construct($coleccion){
   try {
     
    $mongo = new \MongoClient();
    $this->db = $mongo->haterapp->$coleccion;

  } catch (MongoConnectionException $e){
    echo $e->getMessage;
    die($e->getMessage());
  }
}

public function getConexion(){   
 return $this->db;
}

}