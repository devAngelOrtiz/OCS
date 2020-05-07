<?php
	session_start();
	if($_SESSION['nom_adm']==null)
		header('Location: index.html');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css-jss/estilos.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="css-jss/menu.js"></script>
	<title>Consola :: Administrador</title>
</head>
<body>
	<div class="encabezado">
		<table class="encabezado-table"  ALIGN="RIGHT">
			<tr>					
				<td>
					<img class="encabezado-ico" src="img/l_usuario.png"/>
				</td>
				<td>
					<label><?=$_SESSION['nom_adm'];?></label>
				</td>
		   	</tr>
		   	<tr>
				<td></td><td>
					<a href="cerrarsession.php">Cerrar sesión</a>
				</td>
		   	</tr>
		  </table>
	</div>
	<div class="menu">
		<label>MENÚ</label>
		<a href="" id='categorias'>Categorias</a>
		<a href="" id='subcategorias'>Subcategorias</a>
		<a href="" id="productos">Productos</a>
		<a href="" id="usuarios">Usuarios</a>
		<a href="" id="pedidos">Pedidos</a>
		<a href="" id="reportes">Reportes</a>
	</div>
	<div class="lista">
		<div id="titulo" class="titulo">
			<span>Bienvenido</span>
		</div>
		<div id="contenido" class="contenido">
			<h3>Ha ingresado a la consola del sistema OCS.<br>Si tiene alguna duda del funcionamiento de la consola, consultar el manual de usuario.<br>Si tiene algún problema técnico, favor de comunicarse con el soporte técnico.</h3>
		</div>
		

	</div>
</body>


</html>
