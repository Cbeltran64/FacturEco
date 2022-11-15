<?php
    session_start();
    if($_SESSION['rol'] != 1)
    {
        header("location: ./");
    }

    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol'])) {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $user = $_POST['usuario'];
            $clave = md5($_POST['clave']);
            $rol = $_POST['rol'];
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$correo'");
            mysqli_close($conexion);
            $result = mysqli_fetch_array($query);
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
            <form action="" method="post">
                <label for="nombre"><i class="fas fa-user"></i> Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
                <label for="correo"><i class="fas fa-envelope"></i> Correo Electronico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo Electronico">
                <label for="usuario"><i class="fas fa-user"></i> Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                <label for="clave"><i class="fas fa-lock"></i> Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">
                <label for="rol"><i class="fas fa-cogs"></i> Tipo de Usuario</label>

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