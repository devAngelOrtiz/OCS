<?php
	include('funciones/DB.php');
	$db=conectar();
	if($db!=null)
	{
		$query = $db->prepare("SELECT nombre,email FROM cliente ORDER BY nombre");
	    $query->execute();
	    echo "<table>
				<tr class='fondo'><td>Nombre</td><td>Correo</td><tr>";
		while( $row=($query->fetch(PDO::FETCH_NUM)) )
		{
			echo "<tr><td class='cliente'>".$row[0]."</td><td class='nombre'>".$row[1]."</td><tr>";
		}
		echo "<table>";
	}
	else
		echo "ERROR:No se pudo conectar a la base de datos";
?>