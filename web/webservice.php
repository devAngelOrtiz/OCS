<?php 
	include 'Equipos.class.php';
	$soap=new SoapServer(null,array('uri'=>'http://localhost/'));
	$soap->setClass('Equipos');
	$soap->handle();
?>