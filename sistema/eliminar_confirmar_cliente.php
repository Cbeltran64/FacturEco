<?php
    session_start();
    include "../conexion.php";
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }
    

    if(!empty($_POST)){
        if(empty($_POST['idcliente'])){
            header('Location: lista_cliente.php');
            exit;
        }

        $idcliente = $_POST['idcliente'];
        //$query_delete = mysqli_query($conexion, "DELETE FROM cliente WHERE idcliente = $idcliente");
        $query_delete = mysqli_query($conexion, "UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente");
        if($query_delete){
            header("location: lista_cliente.php");
        }else{
            echo "Error al eliminar";
        }
    }

    if (empty($_REQUEST['id'])) {
        header('location: lista_cliente.php');
    }else{
        include "../conexion.php";
        
        $idcliente = $_REQUEST['id'];
        $query= mysqli_query($conexion, "SELECT * FROM cliente
                                         WHERE idcliente = $idcliente");
        $result = mysqli_num_rows($query);

        if($result > 0){
            while ($data = mysqli_fetch_array($query)) {
                $cc         = $data['cc'];
                $nombre     = $data['nombre'];
            }
        }else{
            header('location: lista_cliente.php');
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eliminar Cliente</title>
	<?php include "include/scripts.php";?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class="data_delete">
            <h1>Eliminar Cliente</h1>
            <i class="icon-user icon-5x" style="color: #e66262;"></i>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Nombre del Cliente: <span><?php echo $nombre; ?></span></p>
            <p>Cedula de Ciudadania: <span><?php echo $cc; ?></span></p>
            <form method="post" action="">
                <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
                <a href="lista_cliente.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_ok">
            </form>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>