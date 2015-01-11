<?php

error_reporting(E_ALL); //Change this in production
ini_set('display_errors', '1');
require '../3rd_party/vendor/autoload.php';
use haterApp\api\libs\models\Moderados;
$slim = new \Slim\Slim();

$loader = new Twig_Loader_Filesystem('../app/templates');
$twig = new Twig_Environment($loader);

$slim->get('/', function() use ($twig){
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
      "tags" => $input->tags,
      "usuario" => $input->usuario,
      "sexo"  => $input->sexo,
      'mensaje' => $input->mensaje,
       "aprobado" => 0,
       "rechazado" => 0
       );
    $api = new Moderados; 
    $api->saveModerados($post);
     // return JSON-encoded response body
    echoRespnse(201,$post);

  } catch (Exception $e) {
    echoRespnse(400,$e->getMessage());
  }

});


$slim->get('/api', function() use ($slim){
     $db = new DB;
    $db->listar();

});


/**
 * Respuesta json para el cliente.
 * @param String $status_code Codigo respuesta http
 * @param Int $response Respuesta JSON
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

   echo json_encode($response);

}

$slim->run();