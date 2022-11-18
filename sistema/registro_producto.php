<?php
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
    {
        header("location: ./");
    }
    if (!empty($_POST)) {
        $alert='';
        if (empty($_POST['proveedor']) || empty($_POST['producto'])  || empty($_POST['precio'])  || ($_POST['precio']) <=0 || empty($_POST['cantidad']) || ($_POST['cantidad'])<=0) {
            $alert = '<p class="msg_error">Todos los campos marcados con el * son obligatorios.</p>';
        }else{
            include "../conexion.php";
            $proveedor = $_POST['proveedor'];
            $producto = $_POST['producto'];
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];
            $usuario_id = $_SESSION['idUser'];
            
            $imgProducto = 'img_producto.png';

            $foto = $_FILES['foto'];
            $nombre_foto = $foto['name'];
            $type = $foto['type'];
            $url_temp = $foto['tmp_name'];
            $imgProducto = 'img_producto.png';
            if ($nombre_foto != '') {
                $destino = 'img/uploads/';
                $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
                $imgProducto = $img_nombre.'.jpg';
                $src = $destino.$imgProducto;
            }

            $query_insert = mysqli_query($conexion,"INSERT INTO producto(proveedor,descripcion,precio,existencia,usuario_id,foto)
                                                                    VALUES('$proveedor','$producto','$precio','$cantidad','$usuario_id','$imgProducto')");
            
            if ($query_insert) {
                if ($nombre_foto != '') {
                    move_uploaded_file($url_temp,$src);
                }
                $alert = '<p class="msg_save">Producto guardado correctamente.</p>';
            }else{
                $alert = '<p class="msg_error">Error al guardar el Producto.</p>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro Producto</title>
	<?php include "include/scripts.php"?>
    <script type="text/javascript" src="js/functions.js"></script>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
        <div class ="form_register">
            <h1><i class="fas fa-cubes"></i> Registro Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '';?></div>
            <form action="" method="post" enctype="multipart/form-data">

                <label for="proveedor"><i class="fas fa-truck"></i> Proveedor:<span style="color: red;"> *</span></label>
                <?php
                    include "../conexion.php";
                    $query_proveedor = mysqli_query($conexion,"SELECT codproveedor,proveedor FROM proveedor WHERE estatus = 1 ");
                    $result_proveedor = mysqli_num_rows($query_proveedor);
                ?>
                <select name="proveedor" id="proveedor">
                <?php
                    if ($result_proveedor > 0) {
                        while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                ?>
                            <option value="<?php echo $proveedor['codproveedor'];?>"><?php echo $proveedor['proveedor']?></option>
                 <?php
                        }
                    }
                ?>
                </select>
                
                <label for="producto"><i class="fas fa-user"></i> Contacto: <span style="color: red;"> *</span></label>
                <input type="text" name="producto" id="producto" placeholder="Nombre del producto">

                <label for="precio"><i class="fas fa-dollar-sign"></i> Precio: <span style="color: red;"> *</span></label>
                <input type="number" name="precio" id="precio" placeholder="Precio del producto">


                <label for="cantidad"><i class="fas fa-table"></i> Cantidad: <span style="color: red;"> *</span></label>
                <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del producto">
                
                <div class="photo">
                    <label for="foto"><i class="fas fa-image"></i> Foto: </label>
                    <div class="prevPhoto">
                    <span class="delPhoto notBlock">X</span>
                    <label for="foto"></label>
                    </div>
                    <div class="upimg">
                    <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>

                <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Producto</button>
            </form>
        </div>
	</section>
	<?php include "include/footer.php";?>
</body>
</html>