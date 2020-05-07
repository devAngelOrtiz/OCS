<?php
	include('../funciones/DB.php');
	if($_POST['acc']=='mod')
		modProducto($_POST['id'],$_POST['sub']);
	else
		updProducto($_POST,$_FILES);
?>
