<?php 
	include_once "Vehiculo.php";

	echo "Hola";

	$vehiculo2= new Vehiculo("ABC123", "tarde", 1500);
	
	Vehiculo::Guardar($vehiculo2);
 ?>