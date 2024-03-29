<?php 
	session_start();
	include "../conexion.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sisteme Peoductos</title>
	<?php include "include/scripts.php";?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<h1><i class="fas fa-cube"></i> Lista de Peoductos &nbsp;&nbsp;&nbsp;&nbsp;</h1>
		<a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Crear Producto</a>
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
		</form>
		<table>
			<tr>
				<th>Codigo</th>
                <th>descripcion</th>
				<th>Precio</th>
				<th>Existencias</th>
				<th>Proveedor</th>
                <th>foto</th>
				<th>Acciones</th>
			</tr>
			<?php
				/*paginador*/
				include("../conexion.php");
				$sql_registe = mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM producto 
														WHERE estatus = 1");
				$result_register = mysqli_fetch_array($sql_registe);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 10;

				if(empty($_GET['pagina'])){
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];					
				}

				$desde = ($pagina-1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);


				$query = mysqli_query($conexion, "SELECT p.codproducto, p.descripcion, p.precio, p.existencia, pr.proveedor, p.foto 
                                                  FROM producto p
                                                  INNER JOIN proveedor pr on p.proveedor=pr.codproveedor
                                                   WHERE p.estatus = 1 Order by p.codproducto DESC LIMIT $desde,$por_pagina ");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
                       if ($data["foto"] != 'img_producto.png') {
                            $foto = 'img/uploads/'.$data["foto"];
                       }else{
                            $foto = 'img/uploads/'.$data["foto"];
                       }
			?>
						<tr class="row<?php echo $data["codproducto"]; ?>">
							<td><?php echo $data["codproducto"]; ?></td>
                            <td><?php echo $data["descripcion"]; ?></td>
							<td class="celPrecio"><?php echo $data["precio"]; ?></td>
							<td class="celEcistencia"><?php echo $data["existencia"]; ?></td>
							<td><?php echo $data["proveedor"]; ?></td>
                            <td class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data["descripcion"]; ?>"></td>
                            <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){?>
							<td>
								<a class="link_add add_product"  product="<?php echo $data["codproducto"]; ?>" href="#"><i class="fas fa-plus"></i> Agregar</a>
									|
                                <a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="far fa-edit"></i> Editar</a>
									|
								<a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-trash-alt"></i> Eliminar</a>
							</td>
                            <?php } ?>
						</tr>
						<?php
					}
				}
			?>
		</table>
		<div class="paginador">
			<ul>
				<?php 
					if($pagina != 1)
					{
				 ?>
					<li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
					<li><a href="?pagina=<?php echo $pagina-1; ?>"><i class="fas fa-backward"></i></a></li>
				<?php
					}
					for ($i=1; $i <= $total_paginas; $i++) { 
						if ($i == $pagina) {
							echo '<li class="pageSelected">'.$i.'</li>';
						}else{
							echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
						}
					}
					if($pagina != $total_paginas)
					{
				?>
					<li><a href="?pagina=<?php echo $pagina+1; ?>"><i class="fas fa-forward"></i></a></li>
					<li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>
				<?php 
					}
				?>
			</ul>
		</div>

	</section>
	<?php include "include/footer.php";?>
</body>
</html>