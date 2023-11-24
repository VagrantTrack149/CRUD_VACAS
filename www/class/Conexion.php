<?php 
    class Conexion{
        public $servidor ='db';
        public $usuario= 'root';
        public $password ='clave';
        public $DB='Granja';
        public $port= 3306;
        public function connect(){
            return mysqli_connect($this->servidor, $this->usuario, $this->password, $this->DB, $this->port);
        }
    }
?>