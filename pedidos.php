<?php
	include('funciones/DB.php');
	$db=conectar();
	if($db!=null)
	{
		$query = $db->prepare("SELECT c.nombre,p.status,p.id FROM pedido AS p INNER JOIN cliente AS c ON p.id_cliente=c.id ORDER BY c.nombre");
	    $query->execute();
	    echo "<table>
				<tr class='fondo'><td class='cliente'>Nombre del cliente</td><td>Estado</td><td colspan='2'>Acciones</td><tr>";
		while( $row=($query->fetch(PDO::FETCH_NUM)) )
		{
			echo "	<tr>
						<td>".$row[0]."</td>
						<td>".$row[1]."</td>
						<td class='acciones'><a onclick='pdfpedido(".$row[2].");'><img src='img/pdf.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='imprimirpdfpedido(".$row[2].");'><img src='img/print.png' class='icoacc'/></a></td>
					</tr>";
		}
		echo "<table>";
	}
	else
		echo "ERROR:No se pudo conectar a la base de datos";
?>