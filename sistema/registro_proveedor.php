<?php
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }
    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['proveedor']) || empty($_POST['contacto'])  || empty($_POST['telefono']) || empty($_POST['direccion'])) {
            $alert = '<p class="msg_error">Todos los campos marcados con el * son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $proveedor = $_POST['proveedor'];
            $contacto = $_POST['contacto'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $usuario_id = $_SESSION['idUser'];

            $query_insert = mysqli_query($conexion,"INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id) 
                                                    VALUES('$proveedor','$contacto','$telefono','$direccion','$usuario_id')");
            if ($query_insert) {
                $alert = '<p class="msg_save">Proveedor guardado correctamente.</p>';
            }else{
                $alert = '<p class="msg_error">Error al guardar el Proveedor.</p>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro Proveedor</title>
	<?php include "include/scripts.php"?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1><i class="fas fa-building"></i> Registro Proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <form action="" method="post">
                <label for="proveedor"><i class="fas fa-truck"></i> Proveedor:<span style="color: red;"> *</span></label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor">
                <label for="contacto"><i class="fas fa-user"></i> Contacto: <span style="color: red;"> *</span></label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto">
                <label for="telefono"><i class="fas fa-phone"></i> Telefono: <span style="color: red;"> *</span></label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono">
                <label for="direccion"><i class="fas fa-map-pin"></i> Direccion: <span style="color: red;"> *</span></label>
                <input type="text" name="direccion" id="direccion" placeholder="Direcion Completa">
                
                <button type="submit" class="btn_save"><i class="far fa-save"></i> Crear Proveedor</button>
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>