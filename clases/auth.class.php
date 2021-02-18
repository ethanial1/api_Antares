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
                $password = parent::encriptar($password); #encripamos la contraseña

                $datos = $this->obtenerDatosUsuario($email);
                if($datos){
                    //si existe el usuario, verificamos si la contraseña es correcta.
                    if($password == $datos[0]['password']){
                        if($datos[0]['estado'] == "Activo"){
                            //creamos el token
                            $verificado = $this->insertarToken($datos[0]['Id']);
                            if($verificado){
                                //se guardó el token
                                $result = $_respuestas->respons;
                                $result['result'] = array(
                                    "token" => $$verificado
                                );

                                return $result;
                            }else{
                                //error al guardar el token
                                return $_respuestas->error_500();
                            }
                        }else{
                            //el usuario no está activo
                            return $_respuestas->error_200("Usuario está inactivo");
                        }
                    }else{
                        //no existe el usuario
                        return $_respuestas->error_200("La contraseña no es correcta");
                    }
                }else{
                    //no existe el usuario
                    return $_respuestas->error_200("El usuario con el correo $email no existe");
                }
            }
        }

        private function obtenerDatosUsuario($email){
            $query = "SELECT email, password FROM Usuarios WHERE email = '$email'";
            $datos = parent::obtenerDatos($query);

            if(isset($datos[0]['Id'])){
                return $datos;
            }else{
                return 0;
            }
        }

        private function insertarToken($usuarioId){
            $val = true;
            $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
            $date = date("T.m.d H:i");
            $estado = "activo";

            $query = "INSERT INTO usuarios_token (UserId, Token, Estado, Fecha) VALUES ('$usuarioId', '$token', '$estado', '$date')";

            $verificar = parent::nonQuery($query);
            if($verificar){
                return $token;
            }else{
                return 0;
            }
        }
    }