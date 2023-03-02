<?php
    session_start();
    if($_SESSION['rol'] != 1)
    {
        header("location: ./");
    }
    $validarClave = true;
    if(!empty($_POST['clave'])){
        $claves = $_POST['clave'];
        if(strlen($claves) < 6){
            $alert1 = '<p class="msg_error">La clave debe tener al menos 6 caracteres</p>';
            $validarClave = false;
        }
        if(strlen($claves) > 16){
            $alert2 = '<p class="msg_error">La clave no puede tener más de 16 caracteres</p>';
            $validarClave = false;
        }
        if (!preg_match('`[a-z]`',$claves)){
            $alert3 = '<p class="msg_error">La clave debe tener al menos una letra minúscula</p>';
            $validarClave = false;
        }
        if (!preg_match('`[A-Z]`',$claves)){
            $alert4 = '<p class="msg_error">La clave debe tener al menos una letra mayúscula</p>';
            $validarClave = false;
        }
        if (!preg_match('`[0-9]`',$claves)){
            $alert5 = '<p class="msg_error">La clave debe tener al menos un caracter numérico</p>';
            $validarClave = false;
        }
    } 


    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) 
            || empty($_POST['clave']) || empty($_POST['rol']) || $validarClave == false) {
            if($validarClave != false){
                $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
            }
        }else{
            include "../conexion.php";
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $user = $_POST['usuario'];
            $clave = md5($_POST['clave']);
            $rol = $_POST['rol'];
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$correo'");
            $result = mysqli_fetch_array($query);

            if (empty($_POST['clave'])) {
                
            }

            if ($result > 0) {
                $alert = '<p class="msg_error">El correo o el usuario ya existe.</p>';
            }else{
                $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre, correo, usuario, clave, rol) VALUES('$nombre', '$correo', '$user', '$clave', '$rol')");
                if ($query_insert) {
                    $alert = '<p class="msg_save">Usuario creado correctamente.</p>';
                }else{
                    $alert = '<p class="msg_error">Error al crear el usuario.</p>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro Usuario</title>
	<?php include "include/scripts.php"?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1><i class="fas fa-user-plus"></i> Registro Usuario</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <div class="alert"><?php echo isset($alert1) ? $alert1 : '';?></div>
            <div class="alert"><?php echo isset($alert2) ? $alert2 : '';?></div>
            <div class="alert"><?php echo isset($alert3) ? $alert3 : '';?></div>
            <div class="alert"><?php echo isset($alert4) ? $alert4 : '';?></div>
            <div class="alert"><?php echo isset($alert5) ? $alert5 : '';?></div>
            <form action="" method="post">
                <label for="nombre"><i class="fas fa-user"></i> Nombre: <span style="color: red;"> *</span></label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
                <label for="correo"><i class="fas fa-envelope"></i> Correo Electronico: <span style="color: red;"> *</span></label>
                <input type="email" name="correo" id="correo" placeholder="Correo Electronico">
                <label for="usuario"><i class="fas fa-user"></i> Usuario: <span style="color: red;"> *</span></label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                <label for="clave"><i class="fas fa-lock"></i> Contraseña: <span style="color: red;"> *</span></label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">
                <label for="rol"><i class="fas fa-cogs"></i> Tipo de Usuario: <span style="color: red;"> *</span></label>

                <?php
                    include "../conexion.php";
                    $query_rol = mysqli_query($conexion, "SELECT * FROM rol");
                    mysqli_close($conexion);
                    $result_rol = mysqli_num_rows($query_rol);
                ?>
                <select name="rol" id="rol">
                    <?php 
                        if ($result_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                    ?>
                                <option value="<?php echo $rol["idrol"];?>"><?php echo $rol["rol"];?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
                <button type="submit" class="btn_save"><i class="far fa-save"></i> Crear Usuario</button>
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>