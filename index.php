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
                mysqli_close($conexion);
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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FacturEco</title>
    <link rel="stylesheet" type="text/css" href="recursos/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<link rel="icon" href="https://www.flaticon.com/premium-icon/icons/svg/1058/1058927.svg">
</head>
<body>
    <img class="wave" src="recursos/img/wave.png">
	<div class="container">
		<div class="img">
			<img src="recursos/img/bg.svg">
		</div>
		<div class="login-content">
			<form action="" method="post">
				<img src="recursos/img/avatar.svg">
				<h2 class="title">BIENVENIDO</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text"  name="usuario" class="input" placeholder= "Usuario">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="password" name= "clave" class="input" placeholder= "Contraseña">
            	   </div>
            	</div>
            	<a href="#">¿HAS OLVIDADO TU CONTRASEÑA?</a>
				<div class="alert"><?php echo isset($alert)? $alert : '';?></div>
            	<input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
</body>
</html>