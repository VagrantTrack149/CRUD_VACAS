<?php 
    class conexion{
        public $servidor ='db';
        public $usuario= 'user';
        public $password ='test';
        public $DB='Granja';
        public $port= 3306;
        public function connect(){
            return mysqli_connect($this->servidor, $this->usuario, $this->password, $this->DB, $this->port);
        }
    }
?>