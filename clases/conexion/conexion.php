<?php
    class conexion{
        //atributos
        private $server;
        private $user;
        private $password;
        private $database;
        private $port;

        private $conexion;

        function __construct(){
            $lisaDatos = $this->datosConexion();
            foreach ($lisaDatos as $key => $value){
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];
            }

            $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
            if($this->conexion->connect_errno){
                echo 'Algo va mal';
                die();
            }
            

        }

        //leemos los datos del archivo config los cuales son los datos de la base de datos.
        private function datosConexion(){
            $direccion = dirname(__FILE__);
            $jsondata = file_get_contents($direccion. "/". "config");

            return json_decode($jsondata, true);
        }

        //convertimos el array que devuelve la bd a UTF-8
        private function convertUTF8($array){
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
                }
            });

            return $array;
        }

        //Obtener datos de la base de datos
        public function obtenerDatos($query){
            $result = $this->conexion->query($query);
            $resultArray = array();

            foreach($result as $key){
                $resultArray[] = $key;
            }

            return $this->convertUTF8($resultArray);
        }

        //Metodo único para guardar, modificar y eliminar.
        public function nonQuery($query){
            $result = $this->conexion->query($query);

            return $this->conexion->affected_rows;
        }

        //método para saber id del campo afectado INSERT
        public function nonQueryId($query){
            $result = $this->conexion->query($query);
            $filas = $this->conexion->affected_rows;

            if($filas >= 1){
                return $this->conexion->insert_id;
            }else{
                return 0;
            }
        }

        //encripatr
        protected function encriptar($password){
            return md5($password);
        }
    }

?>