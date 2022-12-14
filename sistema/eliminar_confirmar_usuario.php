<?php
    session_start();
    if($_SESSION['rol'] != 1)
    {
        header("location: ./");
    }
    include "../conexion.php";

    if(!empty($_POST)){
        if(empty($_POST['idUsuario'])){
            header('Location: lista_usuario.php');
            exit;
        }

        $idusuario = $_POST['idusuario'];
        //$query_delete = mysqli_query($conexion, "DELETE FROM usuario WHERE idusuario = $idusuario");
        $query_delete = mysqli_query($conexion, "UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");
        if($query_delete){
            header("location: lista_usuario.php");
        }else{
            echo "Error al eliminar";
        }
    }

    if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
        header('location: lista_usuario.php');
    }else{
        include "../conexion.php";
        
        $idusuario = $_REQUEST['id'];
        $query= mysqli_query($conexion, "SELECT u.nombre,u.usuario,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $idusuario");

        $result = mysqli_num_rows($query);

        if($result > 0){
            while ($data = mysqli_fetch_array($query)) {
                $nombre = $data['nombre'];
                $usuario = $data['usuario'];
                $rol = $data['rol'];
            }
        }else{
            header('location: lista_usuario.php');
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eliminar Usuario</title>
	<?php include "include/scripts.php";?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class="data_delete">
            <h1><i class="fas fa-user-times fa-5x" style="color: red;"></i></h1>
            <i class="icon-user icon-5x" style="color: #e66262;"></i>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Nombre: <span><?php echo $nombre; ?></span></p>
            <p>Usuario: <span><?php echo $usuario; ?></span></p>
            <p>Rol: <span><?php echo $rol; ?></span></p>
            <form method="post" action="">
                <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
                <a href="lista_cliente.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </form>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>