<?php
namespace haterApp\libs\models;
use haterApp\libs\Db;
use Rhumsaa\Uuid\Uuid;

  class Publicados {

  	private $db;

  	public function __construct() {
      $db = new Db("publicados");
      $this->db = $db->getConexion();  
    }


    public function recuperarPublicados($pag){

    $postPorPagina =10;
    $skip= ($pag-1)*$postPorPagina;  // 10 -> número de publicaciones por página

    $cursor=  $this->db->find(array())->skip($skip)->limit($postPorPagina);
    //ordena por fecha↓ orden descendente ↓
    $cursor= $cursor->sort(array("fecha"=>-1));

    foreach ($cursor as $doc) {
      print_r($doc);
      $fecha = $doc["fecha"];
      echo date('Y-M-d',$fecha->sec);
    }

      return $cursor;
    }

    public function borrarPublicado($_id){

      return $this->db->remove(array("_id" => $_id), array('w' => 1));
  }

  
  public function recuperarMejoresDia(){

  }

  public function recuperarMejoresSemana(){
    
  }

  public function recuperarMejoresMes(){
    
  }
}