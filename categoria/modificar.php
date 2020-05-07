<?php
	include('../funciones/DB.php');
	if($_POST['acc']=='mod')
		modCategoria($_POST['id']);
	else
		updCategoria($_POST);
?>
