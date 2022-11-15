<?php 
	session_start();
	include "../conexion.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sisteme Ventas</title>
	<?php include "include/scripts.php";?>
</head>
<body>
	<?php include "include/header.php";?>
	<section id="container">
		<h1>Lista de Clientes</h1>
		<a href="registro_cliente.php" class="btn_new">Crear Cliente</a>
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
		</form>
		<table>
			<tr>
				<th>ID</th>
                <th>CC</th>
				<th>Nombre</th>
				<th>telefono</th>
				<th>direccion</th>
				<th>Acciones</th>
			</tr>
			<?php
				/*paginador*/
				include("../conexion.php");
				$sql_registe = mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM cliente 
														WHERE estatus = 1");
				$result_register = mysqli_fetch_array($sql_registe);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 5;

				if(empty($_GET['pagina'])){
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];					
				}

				$desde = ($pagina-1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);


				
				//SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol;
				$query = mysqli_query($conexion, "SELECT * FROM cliente 
                                                   WHERE estatus = 1 Order by idcliente ASC LIMIT $desde,$por_pagina ");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
                        if($data["cc"] == 0 ){
                            $cc = 'C/F';
                        }else{
                            $cc = $data["cc"];
                        }

			?>
						<tr>
							<td><?php echo $data["idcliente"]; ?></td>
                            <td><?php echo $cc; ?></td>
							<td><?php echo $data["nombre"]; ?></td>
							<td><?php echo $data["telefono"]; ?></td>
							<td><?php echo $data["direccion"]; ?></td>
							<td>
								<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-edit"></i> Editar</a>
								<?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){?>	
									|
								<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-trash-alt"></i> Eliminar</a>
								<?php } ?>
							</td>
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