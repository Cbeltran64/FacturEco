<?php
    session_start();
    include "../conexion.php";
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }
    if(!empty($_POST)){
        if(empty($_POST['codproveedor'])){
            header('Location: lista_proveedor.php');
            exit;
        }

        $codproveedor = $_POST['codproveedor'];

        $query_delete = mysqli_query($conexion, "UPDATE proveedor SET estatus = 0 WHERE codproveedor = $codproveedor");

        if($query_delete){
            header("location: lista_proveedor.php");
        }else{
            echo "Error al eliminar";
        }
    }

    if (empty($_REQUEST['id'])) {
        header('location: lista_proveedor.php');
    }else{
        include "../conexion.php";
        
        $codproveedor = $_REQUEST['id'];
        $query= mysqli_query($conexion, "SELECT * FROM proveedor
                                         WHERE codproveedor = $codproveedor");
        $result = mysqli_num_rows($query);

        if($result > 0){
            while ($data = mysqli_fetch_array($query)) {
                $proveedor         = $data['proveedor'];
                $contacto     = $data['contacto'];
            }
        }else{
            header('location: lista_proveedor.php');
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eliminar Proveedor</title>
	<?php include "include/scripts.php";?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class="data_delete">
            <h1><i class="fas fa-building fa-5x" style="color: red;"></i></h1>
            <i class="icon-user icon-5x" style="color: #e66262;"></i>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Nombre Proveedor: <span><?php echo $proveedor; ?></span></p>
            <p>Contacto: <span><?php echo $contacto; ?></span></p>
            <form method="post" action="">
                <input type="hidden" name="codproveedor" value="<?php echo $codproveedor; ?>">
                <a href="lista_proveedor.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </form>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>