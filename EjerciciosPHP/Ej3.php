<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ej 3</title>
	<style>
		
		.resaltar{
			color: blue;
			font-weight: bold;
		}

	</style>

</head>

<body>

	<?php  

	include "Ej3Funciones.php";

	$palabra1="Casa";
	$palabra2="CASA";
	$variable1=8;
	$variable2="8";

	Operaciones::comparaPalabras($palabra1, $palabra2);
	Operaciones::comparaVariables($variable1, $variable2);


	echo "<p class='resaltar' >Esto es un parrafo</p>";

	?>

</body>

</html>