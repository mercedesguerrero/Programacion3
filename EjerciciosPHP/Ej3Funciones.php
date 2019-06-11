<?php

class Operaciones{


	static function comparaPalabras($palabra1, $palabra2)
	{

		$resultado1= strcmp($palabra1, $palabra2);//Devuelve 1 si no son iguales. 0 si son iguales
		$resultado2= strcasecmp($palabra1, $palabra2);

		if ($resultado1) {

			echo $palabra1 . " y " . $palabra2 . " No son iguales" . "<br>";
		}
		else
		{
			echo $palabra1 . " y " . $palabra2 . " Son iguales" . "<br>";
		}

		if ($resultado2) {

			echo $palabra1 . " y " . $palabra2 . " No son iguales" . "<br>";
		}
		else
		{
			echo $palabra1 . " y " . $palabra2 . " Son iguales" . "<br>";
		}

	}

	static function comparaVariables($variable1, $variable2)
	{
		/*
		if($variable1==$variable2)
		{
			echo "Son iguales";
		}
		*/
		if($variable1===$variable2)
		{
			echo $variable1 . " y " . $variable2 . " Son de igual valor e igual tipo" . "<br>";
		}
		else
		{
			echo $variable1 . " y " . $variable2 . " Son de igual valor pero distinto tipo" . "<br>";
		}
	}


}


?>