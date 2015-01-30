<?php

error_reporting(E_ALL); //Change this in production
ini_set('display_errors', '1');
require '../3rd_party/vendor/autoload.php';
use haterApp\libs\models\Moderados;
use haterApp\libs\models\Publicados;
use Rhumsaa\Uuid\Uuid;
$slim = new \Slim\Slim();

$loader = new Twig_Loader_Filesystem('../app/templates');
$twig = new Twig_Environment($loader);

$slim->get('/', function() use ($twig,$slim){

  if(!isset($_COOKIE['_id']))
  {   
    $slim->setCookie('_id',Uuid::uuid4(), time() + 10 * 24 * 60 * 60);
  }

  echo $twig->render('mainpage.html', array() );


});

$slim->get('/test', function() use ($twig){
  echo $twig->render('html.html', array());
});

$slim->get('/test2', function() use ($twig){
  echo $twig->render('html2.html', array());
});

$slim->get('/env_vars', function(){
  var_dump(getenv('USER'))."\n";
});

$slim->post('/login', function() use ($slim){
	echo $slim->request->post('user_login_input');
	echo '<br>';
	echo $slim->request->post('password_login_input');
});


//_________ API REST  _________



// API group
$slim->group('/v1', function () use ($slim) {

  $slim->post('/moderar', function() use ($slim){
    $slim->response()->header("Content-Type", "application/json");

    try {
      //Esto lo debería hacer la clase Moderados
      $body = $slim->request()->getBody();
      $input = json_decode($body); //convert the json into array
      $post = array(  
        "_id" => Uuid::uuid4()->toString(),
        "tags" => $input->tags,
        "usuario" => $input->usuario,
        "sexo"  => $input->sexo,
        'mensaje' => $input->mensaje,
        "aprobado" => 0,
        "rechazado" => 0,
        "usuarios_moderado" => []
        );
      $api = new Moderados; 
      $api->guardarModerados($post);
       // return JSON-encoded response body
      echoResponse(201,$post);

    } catch (Exception $e) {
      echoResponse(400,$e->getMessage());
    }

  });

//_id de usuario o cookie _id
  $slim->get('/moderar/:_id', function($_id) use ($slim){
    $api = new Moderados; 
    try {
      $response = $api->recuperarModerado($_id);

      if(empty($response)){
        $response_err = array(
          "mensaje" => "No hay más publicaciones."
          );
        echoResponse(200,$response_err);
      
      }else {
        echoResponse(200,$response);
      }
      
    } catch (Exception $e) {
      echoResponse(400,$e->getMessage());
    }

    /*
    Revisar if
    */
    

  });
// :votacion -> aprobar o rechazar
  $slim->put('/moderar/:_idPost/:_idUsuario/:votacion', function($_idPost,$_idUsuario,$votacion) use ($slim){
   
    $api = new Moderados; 
    
    $update = $api->moderar($votacion,$_idPost,$_idUsuario);
    
    
    if($update["nModified"] > 0) {
      $cursor = $api->comprobarPublicar($_idPost);
      $respuesta = array(
        "code" => 200,
        "message" => 'El campo "usuarios_moderado", ha sido actualizado.'
        );
      
        echoResponse(200,$respuesta);
    }else   {
     
     $respuesta = array(
      "code" => 400, 
      "message" => 'No se ha encontrado el registro.'
      );
     echoResponse(400,$respuesta);
   }
   
/*
 OJO, SI ESTABLECES EL CODIGO 204 COMO STATUS NO PUEDES ENVIAR NADA. EL BODY 
 DE LA RESPUESTA ESTARÁ SIEMPRE VACIO.
*/



  // comprobarPublicar();
});

  $slim->delete('/moderar/:_id', function($_id) use ($slim){

    $api = new Moderados; 
    
    $borrado= $api->borrarModerado($_id);
    
    if($borrado["n"] > 0) {

      $respuesta = array(
        "code" => 200, 
        "message" => "La publicación: ".$_id." ha sido eliminada correctamente."
        );
      echoResponse(200,$respuesta);
      
    } else {
      
      $respuesta = array(
        "code" => 400, 
        "message" =>  "No existe una publiación con ese id."
        );
      echoResponse(400,$respuesta);
    }
    


  });
//___________   ↓  PUBLICADOS ↓  ______________

$slim->get('/publicados/:pag', function($pag) use ($slim){

    $api = new Publicados; 
    $api->recuperarPublicados($pag);
    //acabar

});

$slim->delete('/publicados/:_id', function($_id) use ($slim){

    $api = new Publicados; 
    $borrado=  $api->borrarPublicado($_id);

    if($borrado["n"] > 0) {

      $respuesta = array(
        "code" => 200, 
        "message" => "La publicación: ".$_id." ha sido eliminada correctamente."
        );
      echoResponse(200,$respuesta);
      
    } else {
      
      $respuesta = array(
        "code" => 400, 
        "message" =>  "No existe una publiación con ese id."
        );
      echoResponse(400,$respuesta);
    }

});
//___________   ↓  USUARIOS ↓  ______________

$slim->post('/usuarios/:usuario', function($usuario) use ($slim){

    $api = new Usuarios;
    $body = $slim->request()->getBody();
      $usuario = json_decode($body); //convert the json into array
    $apy->publicar($usuario);
    

    try {
      
     
     

    
      echoResponse(201,$post);

    } catch (Exception $e) {
      echoResponse(400,$e->getMessage());
    }

    });
});
/**
 * Respuesta json para el cliente.
 * @param String $status_code Codigo respuesta http
 * @param Int $response Respuesta JSON
 */
function echoResponse($status_code, $response) {
  $app = \Slim\Slim::getInstance();
    // Http response code
  $app->status($status_code);

    // setting response content type to json
  $app->contentType('application/json');

  echo json_encode($response);

}

$slim->run();