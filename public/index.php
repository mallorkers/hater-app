<?php

error_reporting(E_ALL); //Change this in production
ini_set('display_errors', '1');
require '../3rd_party/vendor/autoload.php';
use haterApp\api\libs\models\Moderados;
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

$slim->post('/api/moderar', function() use ($slim){
  $slim->response()->header("Content-Type", "application/json");

   try {
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
$slim->get('/api/moderar/:_id', function($_id) use ($slim){
    $api = new Moderados; 
    try {
    $response = $api->recuperarModerado($_id);
     if(empty($respone)){
      $response_err = array(
        "mensaje" => "No hay más publicaciones."
        );
    echoResponse(204,$response_err['mensaje']);
// ACABAR ESTA SHIT
    }
    } catch (Exception $e) {
    echoResponse(400,$e->getMessage());
  }

   // else {
      //echoResponse(200,$response);

   // } 
   
    

});
$slim->post('/api/moderar/:_id/:votacion', function($_id,$votacion) use ($slim){
  $api = new Moderados; 
  try {
      $api->moderar($votacion,$_id);
      $slim->status(204);
  }catch (Exception $e) {
    echoResponse(400,$e->getMessage());
  }



});


$slim->get('/api', function() use ($slim){
      echo "hola";
     $db = new DB;
    $db->listar();

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