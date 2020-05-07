<?php
	class Equipos
	{
		public function reporte($marca)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
				$dbh = new PDO($dsn, $username, $password);
			    $query="SELECT nombre, marca, precio FROM producto WHERE marca LIKE '$marca'";
			    $res  =$dbh->query($query);
			    $equipos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$equipos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $equipos;
		}

		public function pedido($id_pedido)
		{
			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT  producto.nombre, producto.marca, producto.precio, producto_pedido.cantidad, (producto.precio * producto_pedido.cantidad) AS importe
						FROM producto, pedido, producto_pedido
						WHERE pedido.id=producto_pedido.id_pedido AND producto.id=producto_pedido.id_producto AND pedido.id='$id_pedido'";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}

		public function total($id_pedido)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT  SUM(producto.precio * producto_pedido.cantidad) AS importe
						FROM producto, pedido, producto_pedido
						WHERE pedido.id=producto_pedido.id_pedido AND producto.id=producto_pedido.id_producto AND pedido.id='$id_pedido'";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}

		public function nombreCliente($id_pedido)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT cliente.nombre
						FROM pedido, cliente
						WHERE pedido.id='$id_pedido' AND pedido.id_cliente= cliente.id";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}

		public function direccionCliente($id_pedido)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT direccion.calle, direccion.colonia, direccion.municipio, direccion.ciudad, direccion.cp, direccion.telefono
						FROM pedido, direccion
						WHERE pedido.id='$id_pedido' AND pedido.id_cliente= direccion.id_cliente";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}
		public function id_cliente($cliente)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT id FROM Cliente WHERE nombre LIKE '$cliente'";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}

		public function consulta_mas($id, $marca)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT producto.nombre, producto.marca, producto.precio
						FROM producto, pedido, producto_pedido
						WHERE pedido.id_cliente='$id' AND pedido.id= producto_pedido.id_pedido AND producto.id=producto_pedido.id_producto AND producto.marca LIKE '$marca'
						ORDER BY producto_pedido.cantidad DESC";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}

		public function consulta_menos($id, $marca)
		{

			$dsn='mysql:host=localhost;dbname=ocs';
			$username='root';
			$passsword='';

			try {
			    $dbh = new PDO($dsn, $username, $password);
			    $query="SELECT producto.nombre, producto.marca, producto.precio
						FROM producto, pedido, producto_pedido
						WHERE pedido.id_cliente='$id' AND pedido.id= producto_pedido.id_pedido AND producto.id=producto_pedido.id_producto AND producto.marca LIKE '$marca'
						ORDER BY producto_pedido.cantidad ASC";
			    $res  =$dbh->query($query);
			    $pedidos=array();
			    $i=0;

			    foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row)
			    	foreach ($row as $clave => $valor)
			    		$pedidos[$i++]=$valor;

			} catch (PDOException $e) {
			    echo 'Connection failed: ' . $e->getMessage();
			}
			return $pedidos;
		}
	}
?>