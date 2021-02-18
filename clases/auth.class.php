<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.php';

    //heredamos los metodos de la clase conexión
    class auth extends conexion{

        //logIn
        public function logIn($json){
            $_respuestas = new respuestas;

            $datos = json_decode($json, true); #pasamos la variable json a un array asociativo.

            //validamos los campos mandados.
            if(!isset($datos['email']) || !isset($datos['password'])){
                //error en los campos
                return $_respuestas->error_400();
            }else{
                //todo está bien
                $email = $datos['email'];
                $password = $datos['password'];

                $datos = $this->datosUsuario($email);
                if($datos){
                    //si existe el usuario
                }else{
                    //no existe el usuario
                    return $_respuestas->error_200("El usuario con el correo $email no existe");
                }
            }
        }

        private function datosUsuario($email){
            $query = "SELECT email, password FROM Usuarios WHERE email = '$email'";
            $datos = parent::obtenerDatos($query);

            if(isset($datos[0]['Id'])){
                return $datos;
            }else{
                return 0;
            }
        }
    }