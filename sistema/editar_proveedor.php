
<?php
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }
    include "../conexion.php";
    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $codproveedor    = $_POST['id'];
            $proveedor       = $_POST['proveedor'];
            $contacto        = $_POST['contacto'];
            $telefono        = $_POST['telefono'];
            $direccion       = $_POST['direccion'];
            
            $result = 0;
            $sql_update = mysqli_query($conexion, "UPDATE proveedor 
                                                    SET proveedor = '$proveedor', contacto = '$contacto', telefono = '$telefono', direccion = '$direccion' 
                                                    WHERE codproveedor = $codproveedor");

            if ($sql_update) {
                $alert = '<p class="msg_save">Usuario actualizado correctamente.</p>';
            }else{
                $alert = '<p class="msg_error">Error al actualizar el usuario.</p>';
            }
            
        }
    }

    //  Mostrar datos
    if (empty($_REQUEST['id'])) {
        header('Location: lista_proveedor.php');
    }
    $codproveedor = $_REQUEST['id'];

    $sql =  mysqli_query($conexion, "SELECT * FROM proveedor 
                                    WHERE codproveedor = $codproveedor");

    $result_sql = mysqli_num_rows($sql);
    if ($result_sql == 0) {
        header('Location: lista_proveedor.php');
    }else{
        while ($data = mysqli_fetch_array($sql)) {
            $codproveedor  = $data['codproveedor'];
            $proveedor     = $data['proveedor'];
            $contacto      = $data['contacto'];
            $telefono      = $data['telefono'];
            $direccion     = $data['direccion'];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Actualizar Proveedor</title>
	<?php include "include/scripts.php"?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1><i class="fas fa-building"></i> Actualizar Proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <form action="" method="post">
                <input type="hidden"  name="id" value="<?php echo $codproveedor?>">
                <label for="proveedor"><i class="fas fa-warehouse"></i> Proveedor:<span style="color: red;"> *</span></label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor" value="<?php echo $proveedor?>">
                <label for="contacto"><i class="fas fa-user"></i> Contacto: <span style="color: red;"> *</span></label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto" value="<?php echo $contacto?>">
                <label for="telefono"><i class="fas fa-phone"></i> Telefono: <span style="color: red;"> *</span></label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono?>">
                <label for="direccion"><i class="fas fa-map-pin"></i> Direccion: <span style="color: red;"> *</span></label>
                <input type="text" name="direccion" id="direccion" placeholder="Direcion Completa" value="<?php echo $direccion?>">
                
                <button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar Proveedor</button>
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>