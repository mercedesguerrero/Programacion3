<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Constantes en PHP</title>

</head>

<body>

	<?php  

	include "Ej3Funciones.php";

	define("AUTOR", "Juan", true);//scope global por defecto


	echo "El autor es: " . AUTOR;

	?>

</body>

</html>