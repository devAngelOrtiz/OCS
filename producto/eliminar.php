<?php
	include('../funciones/DB.php');
	if($_POST['acc']=='eli')
		eliProductos($_POST['id'],$_POST['sub']);
	else
		delProductos($_POST['id'],$_POST['sub']);
?>