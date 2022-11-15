<?php
    session_start();
    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $cc = $_POST['cc'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $usuario_id = $_SESSION['idUser'];

            $result = 0;
            if (is_numeric($cc) and $cc !=0) {
                $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE cc = '$cc'");
                $result = mysqli_fetch_array($query);
            }

            if ($result > 0) {
                $alert = '<p class="msg_error">El Numero de Cudula ya existe.</p>';
            }else{
                $query_insert = mysqli_query($conexion,"INSERT INTO cliente(cc,nombre,telefono,direccion,usuario_id) VALUES('$cc','$nombre','$telefono','$direccion','$usuario_id')");
                if ($query_insert) {
                    $alert = '<p class="msg_save">Cliente guardado correctamente.</p>';
                }else{
                    $alert = '<p class="msg_error">Error al guardar el cliente.</p>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro Cliente</title>
	<?php include "include/scripts.php"?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1>Registro Cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <form action="" method="post">
                <label for="cc">CC</label>
                <input type="number" name="cc" id="cc" placeholder="Numero de Cedula">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono">
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direcion Completa">
                
                <input type="submit" value="Guardar Cliente" class="btn_save">
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>