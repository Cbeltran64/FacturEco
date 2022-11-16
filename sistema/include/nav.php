<nav>
			<ul>
				<li><a href="#"><i class="fas fa-home"></i> Inicio</a></li>
				<?php
					if($_SESSION['rol'] == 1)
					{	
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
						<li><a href="lista_usuario.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
					</ul>
				</li>
				<?php
					}
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-user"></i> Clientes</a>
					<ul>
						<li><a href="./registro_cliente.php"><i class="fas fa-user-plus"></i> Nuevo Cliente</a></li>
						<li><a href="./lista_cliente.php"><i class="fas fa-users"></i>  Lista de Clientes</a></li>
					</ul>
				</li>
				<?php
					if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)
					{	
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-building"></i> Proveedores</a>
					<ul>
						<li><a href="registro_proveedor.php"><i class="fas fa-plus"></i> Nuevo Proveedor</a></li>
						<li><a href="lista_proveedor.php"><i class="fas fa-th-list"></i> Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php
					}
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-cubes"></i> Productos</a>
					<ul>
						<li><a href="#"><i class="fas fa-plus"></i> Nuevo Producto</a></li>
						<li><a href="#"><i class="fas fa-list"></i> Lista de Productos</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#"><i class="fas fa-file-alt"></i> Facturas</a>
					<ul>
						<li><a href="#">Nuevo Factura</a></li>
						<li><a href="#">Facturas</a></li>
					</ul>
				</li>
			</ul>
		</nav>