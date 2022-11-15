<?php
    $alert = '';
    session_start();
    if(!empty($_SESSION['active'])){
        header('location: sistema/');
    }else{

        if (!empty($_POST)) {
            if (empty($_POST['usuario']) || empty($_POST['clave'])) {
                $alert = 'Ingrese su usuario y su clave';
            }else{
                require_once "conexion.php";
                $user = mysqli_real_escape_string($conexion,$_POST['usuario']);
                $pass = md5(mysqli_real_escape_string($conexion,$_POST['clave']));

                $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
                $result = mysqli_num_rows($query);

                if($result > 0){
                    $data = mysqli_fetch_array($query);
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $data['idusuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['user'] = $data['usuario'];
                    $_SESSION['rol'] = $data['rol'];

                    header('location: sistema/');
                }else{
                    $alert = 'El usuario o la clave son incorrectos';
                    session_destroy();
                }
            }
            
        }
    }
?>