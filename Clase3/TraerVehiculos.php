<?php 

	include_once "Vehiculo.php";


	$listado= Vehiculo::Leer();

	foreach ($listado as $auto) {
		
		$auto->Mostrar();
	}
 ?>