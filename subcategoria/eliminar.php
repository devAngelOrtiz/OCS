<?php
	include('../funciones/DB.php');
	if($_POST['acc']=='eli')
		eliSubcategoria($_POST['id'],$_POST['cat']);
	else
		delSubcategoria($_POST['id'],$_POST['cat']);
?>