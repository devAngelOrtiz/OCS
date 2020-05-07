<?php
	function conectar()
	{ 
		$dsn='mysql:host=localhost;dbname=ocs';
		$username='root';
		$passsword='';
		try
		{
			$db=new PDO($dsn,$username, $passsword);
			return $db;	
		} 
		catch (PDOException $e) {
			//echo $e->getMessage();
    		return null;
		}		
	}
	
	function verificausuario($datos)
	{
		//session_start();
		$db=conectar();
		if($db!=null)
		{
			$prepared = array(
				'usuario' => $datos['usuario'],
				'contra' => $datos['contra']
				);
			$query = $db->prepare("SELECT id,nombre,usuario FROM administrador WHERE usuario=:usuario AND contrasena=:contra");
		    $query->execute($prepared);
			if( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				$_SESSION['id_adm']=$row[0];
				$_SESSION['nom_adm']=$row[1];
				$_SESSION['adm']=$row[2];
				return "true";
			}
			return "Usuario y/o contraseña incorrectos";
		}
		else
			return "ERROR:No se pudo conectar a la base de datos";
	}

	function getselectSubcategorias($select)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM subcategoria ORDER BY nombre");
		    $query->execute();
		    $s= "<select id='idsubcategoria'>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				if($select==$row[0])
					$s.= "<option value=".$row[0]." selected >".$row[1]."</option>";
				else
					$s.= "<option value=".$row[0].">".$row[1]."</option>";
			}
			$s.= "</select>";
			return $s;
		}
		else
			return "ERROR:No se pudo conectar a la base de datos";
	}

	function getSelectCategorias($select)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM categoria  ORDER BY nombre");
		    $query->execute();
		    $s= "<select id='idcategoria'>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				if($select==$row[0])
					$s.= "<option value=".$row[0]." selected >".$row[1]."</option>";
				else
					$s.= "<option value=".$row[0].">".$row[1]."</option>";
			}
			$s.= "</select>";
			return $s;
		}
		else
			return "ERROR:No se pudo conectar a la base de datos";
	}

	function getCategorias()
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM categoria ORDER BY nombre");
		    $query->execute();
		    echo "<table>";
		    echo "<tr class='fondo'><td>Nombre</td><td colspan='3' >Acciones</td><tr>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<tr>
						<td class='nombre'>".$row[1]."</td>
						<td class='acciones'><a onclick='vercategoria(".$row[0].");'><img src='img/ver.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='modcategoria(".$row[0].");'><img src='img/editar.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='elicategoria(".$row[0].");'><img src='img/eliminar.png' class='icoacc'/></a></tr>";
			}
			echo "</table>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function getCategoriaid($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM categoria WHERE id=:id  ORDER BY nombre");
		    $query->execute(array('id' => $id ));
		    return $query;
		}
		else
			return false;
	}

	function setCategoria($datos)
	{
		$db=conectar();
		if($db!=null)
		{
			$prepared = array(
				'nombre' => $datos['nombre'],
				);
			$query = $db->prepare("INSERT INTO categoria (nombre) VALUES (:nombre)");
		    try {
		    	$query->execute($prepared);
		    	echo "Sus datos se han guardado exitosamente";
		    } 
		    catch ( PDOException $e) 
		    {
		    	echo "ERROR: No se puede insertar en la base de datos\nIntente mas tarde";
		    }	
		    	
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function verCategoriaid($id)
	{
		$db=conectar();
		$query=getCategoriaid($id);
		if($query!=false)
		{
			if($query)
			{
				echo "<table>";
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo 	"<tr>
								<td width='45%'><span class='r'>Nombre:</span></td><td width='70%'><span class='l'>".$row[1]."</span></td>
							</tr>";
				}
				echo "</table>";
				echo "<center><input type='submit' value='Aceptar' onclick='categorias();' class='aceptar'/></center>";
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='categorias();' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='categorias();' class='aceptar'/></center>";
	}

	function modCategoria($id)
	{
		$db=conectar();
		$query=getCategoriaid($id);
		if($query!=false)
		{
			if($query)
			{
				
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo "<form onsubmit='return updcategoria(".$row[0].")'><table>
						 	<tr>
								<td width='30%'><span class='r'>Nombre:</span></td><td width='70%'><input class='entrada-texto' id='nombre' type='text' value='".$row[1]."' maxlength='45' autofocus required /></td>
							</tr></table>";
					echo "<center><input type='submit' value='Aceptar' class='aceptar'/> <input type='button' value='Cancelar' onclick='categorias();' class='cancelar'/></center>";

				}
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='subcategorias();' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='subcategorias();' class='aceptar'/></center>";
	}

	function updCategoria($datos)
	{
		$db=conectar();
		if($db!=null)
		{
			$prepared = array(
				'nombre' => $datos['nombre'],
				'id' => $datos['id']
				);

			$query = $db->prepare("UPDATE categoria SET nombre=:nombre WHERE id=:id");
			try {
				$query->execute($prepared);
			    echo "Se ha Modificado exitosamente";
			} 
			catch (Exception $e) {
				echo "ERROR:No se modifico excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";

		echo "<center><input type='submit' value='Aceptar' onclick='categorias();' class='aceptar'/></center>";
	}

	function getcountCategoria($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT count(id) FROM subcategoria WHERE idcategoria=:id");
		    $query->execute(array('id' => $id ));
		    if($query)
		    	if( $row=($query->fetch(PDO::FETCH_NUM)) )
		    		return $row[0];
		    	else 
		    		return 0;
		}
		else
			return false;
	}

	function eliCategoria($id)
	{
		$db=conectar();
		$query=getCategoriaid($id);
		$elementos=getcountCategoria($id);
		if($query!=false)
		{
			if($query)
			{
				echo "<table>";
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo 	"<tr>
								<td width='45%'><span class='r'>Nombre:</span></td><td width='70%'><span class='l'>".$row[1]."</span></td>
							</tr>";
				}
				echo "</table>";
				if($elementos>0)
					echo "<center><p class='texterror'>Nota:No se puede eliminar la categoria debido a que tiene subcategorias</p></center><center>".
						 "<input type='submit' value='Mostar Subcategoria(s)' onclick='verSubcategoriasCategorias(".$id.");' class='mostrar'/> <input type='button' value='Cancelar' onclick='categorias();' class='cancelar'/></center>";
				else
					echo "<center><input type='submit' value='Aceptar' onclick='delcategoria(".$row[0].");' class='aceptar'/> <input type='button' value='Cancelar' onclick='categorias();' class='cancelar'/></center>";
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='subcategorias();' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='subcategorias();' class='aceptar'/></center>";
	}

	function delCategoria($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("DELETE FROM categoria WHERE id=:id");
			try {
				$query->execute(array('id' => $id ));
			    echo "Se ha Eliminado exitosamente";
			} 
			catch (Exception $e) {
				echo "ERROR:No se elimino excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";

		echo "<center><input type='submit' value='Aceptar' onclick='categorias();' class='aceptar'/></center>";
	}

	function getSubcategorias()
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM subcategoria ORDER BY nombre");
		    $query->execute();
		    echo "<table>";
		    echo "<tr class='fondo'><td>Nombre</td><td colspan='3' >Acciones</td><tr>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<tr>
						<td class='nombre'>".$row[1]."</td>
						<td class='acciones'><a onclick='versubcategoria(".$row[0].",0);'><img src='img/ver.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='modsubcategoria(".$row[0].",0);'><img src='img/editar.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='elisubcategoria(".$row[0].",0);'><img src='img/eliminar.png' class='icoacc'/></a></tr>";
			}
			echo "</table>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function getSubcategoriasCategoria($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM subcategoria WHERE idcategoria=:id  ORDER BY nombre");
		    $query->execute(array('id' => $id ));
		    echo "<table>";
		    echo "<tr class='fondo'><td width='50px'>Todos<input type='checkbox' id='selectall' value=0 onClick='selectTodos(this)'/><td>Nombre</td><td colspan='3' >Acciones</td><tr>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<tr>
						<td><center><input type='checkbox' onClick='seleccion(this)' value=".$row[0]." /></center></td>
						<td class='nombre'>".$row[1]."</td>
						<td class='acciones'><a onclick='versubcategoria(".$row[0].",".$id.");'><img src='img/ver.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='modsubcategoria(".$row[0].",".$id.");'><img src='img/editar.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='elisubcategoria(".$row[0].",".$id.");'><img src='img/eliminar.png' class='icoacc'/></a></tr>";
			}
			echo "</table>";
			echo "<center><input type='submit' value='Eliminar' onclick='EliminarSubcategoriasSelec(".$id.")' id='eliminarP' class='cancelar' disabled /><input type='button' value='Modificar' onclick='ModificarSucategoriasSelec(".$id.")' id='modificarP'  class='aceptar' disabled/></center><BR><div id=cam class='fl'></div>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function getSubcategoriaid($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM subcategoria WHERE id=:id ORDER BY nombre");
		    $query->execute(array('id' => $id ));
		    return $query;
		}
		else
			return false;
	}

	function setSubcategoria($datos)
	{
		$db=conectar();
		if($db!=null)
		{
			$prepared = array(
				'nombre' => $datos['nombre'],
				'idcategoria' => $datos['idcategoria']
				);
			$query = $db->prepare("INSERT INTO subcategoria (nombre, idcategoria) VALUES (:nombre, :idcategoria)");
		    try {
		    	$query->execute($prepared);
		    	echo "Sus datos se han guardado exitosamente";
		    } 
		    catch ( PDOException $e) 
		    {
		    	echo "ERROR: No se puede insertar en la base de datos\nIntente mas tarde";
		    }	
		    	
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function getcountSubcategoria($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT count(id) FROM producto WHERE id_subcategoria=:id");
		    $query->execute(array('id' => $id ));
		    if($query)
		    	if( $row=($query->fetch(PDO::FETCH_NUM)) )
		    		return $row[0];
		    	else 
		    		return 0;
		}
		else
			return false;
	}

	function verSubcategoriaid($id,$idcat)
	{
		$funcion="subcategorias();";
		if($idcat>0)
			$funcion="verSubcategoriasCategorias(".$idcat.");";
		$db=conectar();
		$query=getSubcategoriaid($id);
		if($query!=false)
		{
			if($query)
			{
				echo "<table>";
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo 	"<tr>
								<td width='45%'><span class='r'>Nombre:</span></td><td width='70%'><span class='l'>".$row[1]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Categoria:</span></td><td width='70%'>";
					$query = $db->prepare("SELECT * FROM categoria WHERE id=:id");
			    	$query->execute(array('id' => $row[2] ));
			    	if( $row2=($query->fetch(PDO::FETCH_NUM)) )
			    		echo "<span class='l'>".$row2[1]."</span>";
					echo 	"</td></tr>";
				}
				echo "</table>";
				echo "<center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
	}

	function eliSubcategoria($id,$idcat)
	{
		$funcion="subcategorias();";
		if($idcat>0)
			$funcion="verSubcategoriasCategorias(".$idcat.");";
		$db=conectar();
		$query=getSubcategoriaid($id);
		$elementos=getcountSubcategoria($id);
		if($query!=false)
		{
			if($query)
			{
				echo "<table>";
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo 	"<tr>
								<td width='45%'><span class='r'>Nombre:</span></td><td width='70%'><span class='l'>".$row[1]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Categoria:</span></td><td width='70%'>";
					$query = $db->prepare("SELECT * FROM categoria WHERE id=:id");
			    	$query->execute(array('id' => $row[2] ));
			    	if( $row2=($query->fetch(PDO::FETCH_NUM)) )
			    		echo "<span class='l'>".$row2[1]."</span>";
					echo 	"</td></tr>";
				}
				echo "</table>";
				if($elementos>0)
					echo "<center><p class='texterror'>Nota:No se puede eliminar la Subcategoria debido a que tiene productos</p></center><center>".
						 "<input type='button' value='Mostar producto(s)' onclick='verProductosSubcategoria(".$id.");' class='mostrar'/> <input type='button' value='Cancelar' onclick='".$funcion."' class='cancelar'/></center>";
				else
					echo "<center><input type='submit' value='Aceptar' onclick='delsubcategoria(".$row[0].",".$idcat.");' class='aceptar'/> <input type='button' value='Cancelar' onclick='".$funcion."' class='cancelar'/></center>";
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
	}

	function delsubcategoria($id,$idcat)
	{
		$funcion="subcategorias();";
		if($idcat>0)
			$funcion="verSubcategoriasCategorias(".$idcat.");";
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("DELETE FROM subcategoria WHERE id=:id");
			try {
				$query->execute(array('id' => $id ));
			    echo "Se ha Eliminado exitosamente";
			} 
			catch (Exception $e) {
				echo "ERROR:No se elimino excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";

		echo "<center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
	}
	
	function modSubcategoria($id,$idcat)
	{
		$funcion="subcategorias();";
		if($idcat>0)
			$funcion="verSubcategoriasCategorias(".$idcat.");";
		$db=conectar();
		$query=getSubcategoriaid($id);
		if($query!=false)
		{
			if($query)
			{
				
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo "<form onsubmit='return updsubcategoria(".$row[0].",".$idcat.")'><table>";
					echo 	"<tr>
								<td width='30%'><span class='r'>Nombre:</span></td><td width='70%'><input class='entrada-texto' id='nombre' type='text' value='".$row[1]."' maxlength='40' autofocus required /></td>
							</tr>
							<tr>
								<td width='30%'><span class='r'>Categoria:</span></td><td width='70%'>".getSelectCategorias($row[2])."</td></tr>";
					echo "</table>";
					echo "<center><input type='submit' value='Aceptar' class='aceptar'/> <input type='button' value='Cancelar' onclick='".$funcion."' class='cancelar'/></center>";

				}
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='subcategorias();' class='aceptar'/></center>";
	}

	function updsubcategoria($datos)
	{
		$funcion="subcategorias();";
		if($datos['cat']>0)
			$funcion="verSubcategoriasCategorias(".$datos['cat'].");";
		$db=conectar();
		if($db!=null)
		{
			$prepared = array(
				'nombre' => $datos['nombre'],
				'idcategoria' => $datos['idcategoria'],
				'id' => $datos['id']
				);

			$query = $db->prepare("UPDATE subcategoria SET nombre=:nombre, idcategoria=:idcategoria WHERE id=:id");
			try {
				$query->execute($prepared);
			    echo "Se ha Modificado exitosamente";
			} 
			catch (Exception $e) {
				echo "ERROR:No se modifico excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";

		echo "<center><input type='submit' value='Aceptar' onclick='".$funcion."' class='aceptar'/></center>";
	}

	function getProductoid($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM producto WHERE id=:id ORDER BY nombre");
		    $query->execute(array('id' => $id ));
		    return $query;
		}
		else
			return false;
	}

	function getProductosSubcategoria($id)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM producto WHERE id_subcategoria=:id ORDER BY nombre");
		    $query->execute(array('id' => $id ));
		    echo "<table>";
		    echo "<tr class='fondo'><td width='50px'>Todos<input type='checkbox' id='selectall' value=0 onClick='selectTodos(this)'/></td><td>Nombre</td><td colspan='3' >Acciones</td><tr>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<tr>
						<td><center><input type='checkbox' onClick='seleccion(this)' value=".$row[0]." /></center></td>
						<td class='nombre'>".$row[1]."</td>
						<td class='acciones'><a onclick='verproductos(".$row[0].",".$id.");'><img src='img/ver.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='modproductos(".$row[0].",".$id.");'><img src='img/editar.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='eliproductos(".$row[0].",".$id.");'><img src='img/eliminar.png' class='icoacc'/></a></tr>";
			}
			echo "</table>";
			echo "<center><input type='submit' value='Eliminar' onclick='EliminarProductoSelec(".$id.")' id='eliminarP' class='cancelar' disabled /><input type='button' value='Modificar' onclick='ModificarProductoSelec(".$id.")' id='modificarP'  class='aceptar' disabled/></center><BR><div id=cam class='fl'></div>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function getProductos()
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT * FROM producto ORDER BY nombre");
		    $query->execute();
		    echo "<table>";
		    echo "<tr class='fondo'><td>Nombre</td><td colspan='3' >Acciones</td><tr>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<tr>
						<td class='nombre'>".$row[1]."</td>
						<td class='acciones'><a onclick='verproductos(".$row[0].",0);'><img src='img/ver.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='modproductos(".$row[0].",0);'><img src='img/editar.png' class='icoacc'/></a></td>
						<td class='acciones'><a onclick='eliproductos(".$row[0].",0);'><img src='img/eliminar.png' class='icoacc'/></a></tr>";
			}
			echo "</table>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function setProducto($datos,$files)
	{
		$db=conectar();
		if($db!=null)
		{
			$prepared = array(
				'nombre' => $datos['nombre'],
				'marca' => $datos['marca'],
				'precio' => $datos['precio'],
				'descripcion' => $datos['descripcion'],
				'idsubcategoria' => $datos['idsubcategoria'],
				'cantidad' => $datos['cantidad']
				);
			$query = $db->prepare("INSERT INTO producto (nombre, marca, precio, descripcion, id_subcategoria,cantidad) VALUES (:nombre, :marca,:precio, :descripcion,:idsubcategoria,:cantidad)");
		    try {
		    	$query->execute($prepared);
		    	
		    	$id=$db->lastInsertId(); 
		    	$destino = "Productos/";
				foreach ($files as $image)
				{
					if($image['name']!="")
					{
						$prefijo = substr(md5(uniqid(rand())), 0,6);
						copy($image['tmp_name'], "../../".$destino.$prefijo."_".$image['name']);
						$query = $db->prepare("INSERT INTO imagen (nombre, id_producto) VALUES (:nombre, :idproducto)");
						$query->execute(array('nombre' => $destino.$prefijo."_".$image['name'],'idproducto' => $id));
					}
				}
		    	echo "Sus datos se han guardado exitosamente";
		    } 
		    catch ( PDOException $e) 
		    {
		    	echo "ERROR: No se puede insertar en la base de datos\nIntente mas tarde";
		    }	
		    	
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}

	function verProductoid($id,$idsub)
	{
		$funcion="'productos();'";
		if($idsub>0)
			$funcion="'verProductosSubcategoria(".$idsub.");'";
		$db=conectar();
		$query=getProductoid($id);
		if($query!=false)
		{
			if($query)
			{
				echo "<table>";
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo 	"<tr>
								<td width='45%'><span class='r'>Nombre:</span></td><td width='70%'><span class='l'>".$row[1]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Marca:</span></td><td width='70%'><span class='l'>".$row[2]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Precio:</span></td><td width='70%'><span class='l'>$".$row[3]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Cantidad:</span></td><td width='70%'><span class='l'>".$row[7]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Descripcion:</span></td><td width='70%'><span class='l'>".$row[4]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Subcategoria:</span></td><td width='70%'>";
					$query = $db->prepare("SELECT * FROM subcategoria WHERE id=:id");
			    	$query->execute(array('id' => $row[5] ));
			    	if( $row2=($query->fetch(PDO::FETCH_NUM)) )
			    		echo "<span class='l'>".$row2[1]."</span>";
					echo 	"</td></tr>
							<tr>
								<td width='45%'><span class='r'>Imagene(s):</span></td><td width='70%'>";
					$query = $db->prepare("SELECT * FROM imagen WHERE id_producto=:id");
			    	$query->execute(array('id' => $row[0] ));
			    	while( $row2=($query->fetch(PDO::FETCH_NUM)) )
			    		echo "<img class='l producto' src='../".$row2[1]."'/> ";
					echo 	"</td></tr>";
				}
				echo "</table>";
				echo "<center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick='productos();' class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick='productos();' class='aceptar'/></center>";
	}

	function modProducto($id,$idsub)
	{
		$funcion="'productos();'";
		if($idsub>0)
			$funcion="'verProductosSubcategoria(".$idsub.");'";
		$db=conectar();
		$query=getProductoid($id);
		if($query!=false)
		{
			if($query)
			{	
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo "<form onsubmit='return updproductos(".$row[0].",".$idsub.")'>
							<table>
								<tr>
									<td width='30%'><span class='r'>Nombre:</span></td><td width='70%'><input class='entrada-texto' id='nombre' type='text' value='".$row[1]."' maxlength='100' autofocus required /></td>
								</tr>
								<tr>
									<td width='30%'><span class='r'>Marca:</span></td><td width='70%'><input class='entrada-texto' id='marca' type='text' value='".$row[2]."' maxlength='45' autofocus required /></td>
								</tr>
								<tr>
									<td width='30%'><span class='r'>Precio:</span></td><td width='70%'><input class='entrada-texto' id='precio' type='text' value='".$row[3]."' autofocus required /></td>
								</tr>
								<tr>
									<td width='30%'><span class='r'>Cantidad:</span></td><td width='70%'><input class='entrada-texto' id='cantidad' type='text' value='".$row[7]."' autofocus required /></td>
								</tr>
								<tr>
									<td width='30%'><span class='r'>Descripcion:</span></td><td width='70%'><textarea rows='5' id='descripcion' maxlength='500' autofocus required >".$row[4]."</textarea></td>
								</tr>
								<tr>
									<td width='30%'><span class='r'>Subcategoria:</span></td><td width='70%'>".getselectSubcategorias($row[5])."</td></tr>
								<tr>
									<td width='45%'><span class='r'>Imagene(s):</span></td><td width='70%'>";
									$query = $db->prepare("SELECT * FROM imagen WHERE id_producto=:id");
							    	$query->execute(array('id' => $row[0] ));
				    				while( $row2=($query->fetch(PDO::FETCH_NUM)) )
				    					echo "<div id='img".$row2[0]."'><img class='productoeli' src='../".$row2[1]."'/><a onClick='EliminarImagen(".$row2[0].",\"".$row2[1]."\")'><img class='icoacc' src='img/eliminar.png'/></a></div><div id='".$row2[0]."'></div><BR>";
						echo 	"</td></tr>
								<tr>
									<td>
										<span class='r'>Agregar Imagen: </span></td><td><input class='entrada-texto' type='file' id='file'  multiple='' accept='image/jpeg, image/png'>
									</td>
								</tr>
							</table>
							<center><input type='submit' value='Aceptar' class='aceptar'/> <input type='button' value='Cancelar' onclick=".$funcion." class='cancelar'/></center>";

				}
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
	}

	function updProducto($datos,$files)
	{
		$funcion="'productos();'";
		if($datos['sub']>0)
			$funcion="'verProductosSubcategoria(".$datos['sub'].");'";
		$db=conectar();
		if($db!=null)
		{
			$destino = "Productos/";
			foreach ($files as $image)
			{
				if($image['name']!="")
				{
					$prefijo = substr(md5(uniqid(rand())), 0,6);
					copy($image['tmp_name'], "../../".$destino.$prefijo."_".$image['name']);
					$query = $db->prepare("INSERT INTO imagen (nombre, id_producto) VALUES (:nombre, :idproducto)");
					$query->execute(array('nombre' => $destino.$prefijo."_".$image['name'],'idproducto' => $datos['id']));
				}
			}
		
			$prepared = array(
				'nombre' => $datos['nombre'],
				'marca' => $datos['marca'],
				'precio' => $datos['precio'],
				'descripcion' => $datos['descripcion'],
				'idsubcategoria' => $datos['idsubcategoria'],
				'cantidad' => $datos['cantidad'],
				'id' => $datos['id'],
			);
			$query = $db->prepare("UPDATE producto SET nombre=:nombre, marca=:marca, precio=:precio, descripcion=:descripcion, id_subcategoria=:idsubcategoria, cantidad=:cantidad WHERE id=:id");
			try {
				$query->execute($prepared);
			    echo "Se ha Modificado exitosamente";
			} 
			catch (Exception $e) {
				echo "ERROR:No se modifico excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";

		echo "<center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
	}
	function updProductovarios($datos)
	{
		$db=conectar();
		if($db!=null)
		{
			for($i=1;$i<sizeof($datos);$i++)
			{
				$prepared = array(
					'idsubcategoria' => $datos[0],
					'id' => $datos[$i],
				);
				$query = $db->prepare("UPDATE producto SET id_subcategoria=:idsubcategoria WHERE id=:id");
				try {
					$query->execute($prepared);
				} 
				catch (Exception $e) {
					echo "ERROR:No se modifico excitosamente. Vuelva a intentarlo mas tarde<BR>";
					return;
				}
			}
			echo "Se ha Modificado exitosamente<BR>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";
	}

	function eliProductos($id,$idsub)
	{
		$funcion="'productos();'";
		if($idsub>0)
			$funcion="'verProductosSubcategoria(".$idsub.");'";
		$db=conectar();
		$query=getProductoid($id);
		if($query!=false)
		{
			if($query)
			{
				echo "<table>";
				if( $row=($query->fetch(PDO::FETCH_NUM)) )
				{
					echo 	"<tr>
								<td width='45%'><span class='r'>Nombre:</span></td><td width='70%'><span class='l'>".$row[1]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Marca:</span></td><td width='70%'><span class='l'>".$row[2]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Precio:</span></td><td width='70%'><span class='l'>$".$row[3]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Cantidad:</span></td><td width='70%'><span class='l'>".$row[7]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Descripcion:</span></td><td width='70%'><span class='l'>".$row[4]."</span></td>
							</tr>
							<tr>
								<td width='45%'><span class='r'>Subcategoria:</span></td><td width='70%'>";
					$query = $db->prepare("SELECT * FROM subcategoria WHERE id=:id");
			    	$query->execute(array('id' => $row[5] ));
			    	if( $row2=($query->fetch(PDO::FETCH_NUM)) )
			    		echo "<span class='l'>".$row2[1]."</span>";
					echo 	"</td></tr>
							<tr>
								<td width='45%'><span class='r'>Imagene(s):</span></td><td width='70%'>";
					$query = $db->prepare("SELECT * FROM imagen WHERE id_producto=:id");
			    	$query->execute(array('id' => $row[0] ));
			    	while( $row2=($query->fetch(PDO::FETCH_NUM)) )
			    		echo "<img class='l producto' src='../".$row2[1]."'/> ";
					echo 	"</td></tr>";
				}
				echo "</table>";
				echo "<center><input type='submit' value='Aceptar' onclick='delproductos(".$row[0].",".$idsub.");' class='aceptar'/> <input type='button' value='Cancelar' onclick=".$funcion."class='cancelar'/></center>";
			}
			else
				echo "ERROR:No se puede consultar la base de datos. Intentlo mas tarde<BR><center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR><center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
	}

	function delProductos($id,$idsub)
	{
		$funcion="'productos();'";
		if($idsub>0)
			$funcion="'verProductosSubcategoria(".$idsub.");'";
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("DELETE FROM producto WHERE id=:id");
			try {
				$query->execute(array('id' => $id ));
				$query2 = $db->prepare("SELECT nombre FROM imagen WHERE id_producto=:id");
				$query2->execute(array(	'id' => $id	));
				while( $row=($query2->fetch(PDO::FETCH_NUM)) )
					unlink("../../".$row[0]);
				$query3 = $db->prepare("DELETE FROM imagen WHERE id_producto=:id");
				$query3->execute(array(	'id' => $id	));
			    echo "Se ha Eliminado exitosamente";
			} 
			catch (Exception $e) {
				echo "ERROR:No se elimino excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";

		echo "<center><input type='submit' value='Aceptar' onclick=".$funcion." class='aceptar'/></center>";
	}
	function delProductovarios($datos)
	{
		$db=conectar();
		if($db!=null)
		{
			for($i=0;$i<sizeof($datos);$i++)
			{
				$query = $db->prepare("DELETE FROM producto WHERE id=:id");
				try {
					$query->execute(array(	'id' => $datos[$i]	));
					$query2 = $db->prepare("SELECT nombre FROM imagen WHERE id_producto=:id");
					$query2->execute(array(	'id' => $datos[$i]	));
					while( $row=($query2->fetch(PDO::FETCH_NUM)) )
						unlink("../../".$row[0]);
					$query3 = $db->prepare("DELETE FROM imagen WHERE id_producto=:id");
					$query3->execute(array(	'id' => $datos[$i]	));
				} 
				catch (Exception $e) {
					echo "ERROR:No se eliminaron excitosamente. Vuelva a intentarlo mas tarde<BR>";
					return;
				}
			}
			echo "Se han eliminado exitosamente<BR>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";
	}
	
	function delSubcategoriavarios($datos)
	{
		echo "Codigo en proceso<BR>";
	}
	function updSubcategoriavarios($datos)
	{
		echo "Codigo en proceso<BR>";
	}
	function DelImagen($id,$ruta)
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("DELETE FROM imagen WHERE id=:id");
			try {
				$query->execute(array('id' => $id ));
			    unlink("../../".$ruta);
			    echo "true";
			} 
			catch (Exception $e) {
				echo "ERROR:No se elimino excitosamente. Vuelva a intentarlo mas tarde<BR>";
			}
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos<BR>";
	}

	function getSelectClientes()
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT nombre FROM Cliente");
		    $query->execute();
		    echo "<select id='nombre'>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
			echo "</select>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}
	function getSelectMarcas()
	{
		$db=conectar();
		if($db!=null)
		{
			$query = $db->prepare("SELECT marca FROM producto GROUP BY marca");
		    $query->execute();
		    echo "<select id='marca'>";
			while( $row=($query->fetch(PDO::FETCH_NUM)) )
			{
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
			echo "</select>";
		}
		else
			echo "ERROR:No se pudo conectar a la base de datos";
	}
?>