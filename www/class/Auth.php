<?php 
    include "Conexion.php";
    class Auth extends Conexion{
        public function register($nombre, $email, $password){
            $conexion = parent::connect();
            $sql= "INSERT INTO Granja.usuarios(nombre,email,password) VALUES (?,?,?)";
            $query =$conexion ->prepare($sql);
            $query->bind_param('sss',$nombre,$email,$password);
            return $query->execute();
        }
    public function login($email,$password){
        $conexion = parent::connect();
        $passwordExist="";
        $sql="SELECT * FROM usuarios WHERE email='$email'";
        $Answer=mysqli_query($conexion,$sql);
        $passwordExist=mysqli_fetch_array($Answer)['password'];
        if(password_verify($password, $passwordExist)){
            $_SESSION['usuario']=$email;
            return true;
        } else{
            return false;
        }
        }
    }
?>