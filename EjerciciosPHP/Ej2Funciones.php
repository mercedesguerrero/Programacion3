<?php

class Operaciones{


	static function incrementaVariable($variable)
	{

		static $contador;

		$contador ++;

		$variable+= 10;

		echo $contador . "<br>";
		echo $variable . "<br>";

	}


}


?>