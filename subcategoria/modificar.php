<?php
	include('../funciones/DB.php');
	if($_POST['acc']=='mod')
		modSubcategoria($_POST['id'],$_POST['cat']);
	else
		updSubcategoria($_POST);
?>
