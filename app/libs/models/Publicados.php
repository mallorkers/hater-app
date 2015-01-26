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
    $skip= ($pag-1)*10; // 10 -> número de publicaciones por página
    $postPorPagina=5;
  //  $total = (int) ceil($totalArticles/$articlesPerPage);
//ordena por fecha↓ orden descendente ↓
   
 //$cursor=  $this->db->find(array('fecha'=> -1))->skip($skip)->limit(10);
$cursor=  $this->db->find(array())->skip($skip)->limit( $postPorPagina);
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

  
}