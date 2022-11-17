<?php
    session_start();
    include "../conexion.php";
    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $idcliente    = $_POST['id'];
            $cc           = $_POST['cc'];
            $nombre       = $_POST['nombre'];
            $telefono =     $_POST['telefono'];
            $direccion =    $_POST['direccion'];
            
            $result = 0;

            if (is_numeric($cc) and $cc !=0) {
                $query = mysqli_query($conexion,"SELECT * FROM cliente 
                                                  WHERE (cc = '$cc' AND idcliente != $idcliente)");
                $result = mysqli_fetch_array($query);
                $result = count($result);
            }
            
            if ($result > 0) {
                $alert = '<p class="msg_error">El numero de cedula ya existe.</p>';
            }else{
                if (empty($_POST['cc'])) {
                    $cc = 0;
                }
                $sql_update = mysqli_query($conexion, "UPDATE cliente 
                                                        SET cc = '$cc', nombre = '$nombre', telefono = '$telefono', direccion = '$direccion' 
                                                        WHERE idcliente = $idcliente");

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
        header('Location: lista_cliente.php');
    }
    $idcliente = $_GET['id'];

    $sql =  mysqli_query($conexion, "SELECT * FROM cliente 
                                    WHERE idcliente = $idcliente and u.estatus = 1");

    $result_sql = mysqli_num_rows($sql);
    if ($result_sql == 0) {
        header('Location: lista_usuario.php');
    }else{
        while ($data = mysqli_fetch_array($sql)) {
            $idcliente = $data['idcliente'];
            $cc = $data['cc'];
            $nombre = $data['nombre'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Actualizar Cliente</title>
	<?php include "include/scripts.php"?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1><i class="fas fa-pen-square"></i> Actualizar Cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idcliente?>">
                <label for="cc"><i class="fas fa-address-card"></i> Cedula de Ciudadania: </label>
                <input type="number" name="cc" id="cc" placeholder="Numero de Cedula" value="<?php echo $cc?>">
                <label for="nombre"><i class="fas fa-user"></i> Nombre: <span style="color: red;"> *</span></label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre?>">
                <label for="telefono"><i class="fas fa-phone"></i> Telefono: <span style="color: red;"> *</span></label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono?>">
                <label for="direccion"><i class="fas fa-map-pin"></i> Direccion: <span style="color: red;"> *</span></label>
                <input type="text" name="direccion" id="direccion" placeholder="Direcion Completa" value="<?php echo $direccion?>">
                
                <button type="submit" class="btn_save"><i class="fas fa-edit"></i> Actualizar Cliente</button>
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>