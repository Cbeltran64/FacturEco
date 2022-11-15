<?php
    session_start();
    if($_SESSION['rol'] != 1)
    {
        header("location: ./");
    }
    include "../conexion.php";
    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $idusuario = $_POST['idUsuario'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $user = $_POST['usuario'];
            $clave = md5($_POST['clave']);
            $rol = $_POST['rol'];

            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE (usuario = '$user' and idusuario != '$idusuario') OR (correo = '$correo' and idusuario != '$idusuario')");
            
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<p class="msg_error">El correo o el usuario ya existe.</p>';
            }else{
                
                if (empty($_POST['clave'])) {
                    $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$user', rol = '$rol' WHERE idusuario = $idusuario");
                }else{
                    $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$user', clave = '$clave', rol = '$rol' WHERE idusuario = $idusuario");
                }

                if ($sql_update) {
                    $alert = '<p class="msg_save">Usuario actualizado correctamente.</p>';
                }else{
                    $alert = '<p class="msg_error">Error al actualizar el usuario.</p>';
                }
            }
        }
    }
    //  Mostrar datos
    if (empty($_GET['id'])) {
        header('Location: lista_usuario.php');
    }
    $iduser = $_GET['id'];

    $sql =  mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $iduser");

    $result_sql = mysqli_num_rows($sql);
    if ($result_sql == 0) {
        header('Location: lista_usuario.php');
    }else{
        $option = '';
        while ($data = mysqli_fetch_array($sql)) {
            $iduser = $data['idusuario'];
            $nombre = $data['nombre'];
            $correo = $data['correo'];
            $usuario = $data['usuario'];
            $idrol = $data['idrol'];
            $rol = $data['rol'];
            if ($idrol == 1) {
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }elseif ($idrol == 2) {
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }elseif ($idrol == 3) {
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Actualizar Usuario</title>
	<?php include "include/scripts.php"?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1><i class="fas fa-pen-square"></i> Actualizar Usuario</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <form action="" method="post">
                <input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
                <label for="nombre"><i class="fas fa-user"></i> Nombre: <span style="color: red;"> *</span></label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value = "<?php echo $nombre ?>">
                <label for="correo"><i class="fas fa-envelope"></i> Correo Electronico: <span style="color: red;"> *</span></label>
                <input type="email" name="correo" id="correo" placeholder="Correo Electronico" value = "<?php echo $correo ?>">
                <label for="usuario"><i class="fas fa-user"></i> Usuario: <span style="color: red;"> *</span></label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" value = "<?php echo $usuario ?>">
                <label for="clave"><i class="fas fa-lock"></i> Contraseña: </label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">
                <label for="rol"><i class="fas fa-cogs"></i> Tipo de Usuario: <span style="color: red;"> *</span></label>

                <?php
                    include "../conexion.php";
                    $query_rol = mysqli_query($conexion, "SELECT * FROM rol");
                    $result_rol = mysqli_num_rows($query_rol);
                ?>
                <select name="rol" id="rol" class= "notItemone">
                    <?php
                        echo $option;
                        if ($result_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                    ?>
                                <option value="<?php echo $rol["idrol"];?>"><?php echo $rol["rol"];?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
                <button type="submit" class="btn_save"><i class="fas fa-edit"></i> Actualizar Usuario</button>
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>