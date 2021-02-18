<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.php';

$auth = new auth;
$respuestas = new respuestas;

switch($_SERVER['REQUEST_METHOD']){
    case "POST":
        $postBody = file_get_contents("php://input");
        $datosArray = $auth->logIn($postBody);

        print_r(json_encode($datosArray));
        break;
}
