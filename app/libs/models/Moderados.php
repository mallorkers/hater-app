<?php 
namespace haterApp\libs\models;
use haterApp\libs\Db;
use Rhumsaa\Uuid\Uuid;

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

 return $cursor;
}

public function moderar($votacion,$_idPost,$_idUsuario){
  if($votacion=="aprobar") {
    $update = $this->db->update(array('_id' => $_idPost),array('$inc' => array('aprobado' =>1)), array('w' => 1));

  } else if ($votacion=="rechazar") {
    $update =  $this->db->update(array('_id' => $_idPost),array('$inc' => array('rechazado' =>1)), array('w' => 1));

  }  
  //Añadimos a ese mismo docuemnto la id del usuario que lo ha moderado en el campo "usuarios_moderado"
 $this->db->update(array("_id" =>$_idPost),array('$push' => array("usuarios_moderado" => $_idUsuario)));

  return $update;
}


public function borrarModerado($_id){

  return $this->db->remove(array("_id" => $_id), array('w' => 1));


}

/*
* Comprueba si la publicación cumple la condición para ser
publicado.
*/
public function comprobarPublicar($_id){

 //recuperamos los valores "aprobado" y "rechazado" de la colección moderar
 $cursor= $this->db->findOne(array('_id' => $_id), array('aprobado', 'rechazado'));
 $total=$cursor["aprobado"]+$cursor["rechazado"];

  if($total>10){
   if($cursor["aprobado"]/$total >= 0.7 ) {
     
      $this->publicar($_id);

    }else {
      echo  "borrado";
      $this->borrarModerado($_id);
    }


  }

}

public function publicar($_id){
    $moderado = $this->db->findOne(array('_id' => $_id));
    print_r($moderado);
       $publicacion = array(  
        "_id" => Uuid::uuid4()->toString(),
        "tags" => $moderado["tags"],
        "usuario" => $moderado["usuario"],
        "sexo"  => $moderado["sexo"],
        "fecha" => "fecha",
        "mensaje" => $moderado["mensaje"],
        "num_comentarios" => 0,
        "votos_positivos" =>   0,
        "votos_negativos" => 0,
        "comentarios" => []
         );

        $publicados = new Db("publicados");
        $publicados = $publicados->getConexion();
        $publicados->insert($publicacion);

}
 









}


