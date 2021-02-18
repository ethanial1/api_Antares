<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.php';

$_auth = new auth;
$_respuestas = new respuestas;

switch($_SERVER['REQUEST_METHOD']){
    case "POST":
        //recibimos datos
        $postBody = file_get_contents("php://input");

        //enviamos los datos al manejador
        $datosArray = $_auth->logIn($postBody);

        //devolvemos una respuesta
        header('Content-Type: application/json');
        if(isset($datosArray['result']['error_id'])){
            $response_code = $datosArray['result']['error_id'];
            http_response_code($response_code);
        }else{
            http_response_code(200);
        }

        //imprimimos la respuesta
        echo json_encode($datosArray);
        break;
    default:
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_400();
        echo json_encode($datosArray);
        break;
}
