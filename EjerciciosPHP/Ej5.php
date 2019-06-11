<?php  

	$numero1=0;
	$numero2=0;

	$numero1= $_POST['num1'];
	$numero2= $_POST['num2'];

	$operacion= $_POST['operacion'];


	switch ($operacion) {
		case 1:
			echo "El resultado de la suma es: " . ($numero1 + $numero2);
			break;
		case 2:
			echo "El resultado de la resta es: " . ($numero1 - $numero2);
			break;
		case 3:
			echo "El resultado de la multiplicacion es: " . ($numero1 * $numero2);
			break;
		case 4:
			echo "El resultado de la division es: " . ($numero1 / $numero2);
			break;
		
	}

	
?>