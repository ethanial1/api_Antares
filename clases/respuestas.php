<?php
    class respuestas{
        public $respons = [
            "status" => "ok",
            "result" => array()
        ];

        //el usuario envia info por un método no permitido
        public function error_405(){
            $this->respons['status'] = "error";
            $this->respons['result'] = array(
                "error_id" => "405",
                "error_msg" => "Método no permitido"
            );
            return $this->respons;
        }

        public function error_200($string = "Datos incorrectos"){
            $this->respons['status'] = "error";
            $this->respons['result'] = array(
                "error_id" => "200",
                "error_msg" => $string
            );
            return $this->respons;
        }

        //datos enviados de forma incorrecta
        public function error_400(){
            $this->respons['status'] = "error";
            $this->respons['result'] = array(
                "error_id" => "400",
                "error_msg" => "Datos enviados incompletos o enviados con formato incorrecto"
            );
            
            return $this->respons;
        }

        public function error_500($string = "Error interno del servidor"){
            $this->respons['status'] = "error";
            $this->respons['result'] = array(
                "error_id" => "500",
                "error_msg" => $string
            );
            return $this->respons;
        }
    }


?>