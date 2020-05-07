<?php
	
	return;

	$archivoArticulo = $_FILES['archivo']['tmp_name'][0];
	$nombreArchivoArticulo = $_FILES['archivo']['name'][0];
	$tamanoArchivo = $_FILES['archivo']['size'];
	$tipoArchivo = $_FILES['archivo']['type'];
	
	if($nombreArchivoArticulo != "")
	{
		$prefijo = substr(md5(uniqid(rand())), 0,6);

		$destino = "archivo/".$prefijo."_".$nombreArchivoArticulo;

		if(copy($archivoArticulo, $destino))
			$status = "Si se pudo";
		else
			$status = "No se pudo";
	}
?>