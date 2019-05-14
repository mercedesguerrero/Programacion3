<?php 

	class Vehiculo{
		private $_patente;
		private $_ingreso;
		private $_importe;
		

		function __construct($patente, $cuando, $precio)
		{
			$this->_patente= $patente;
			$this->_ingreso= $cuando;
			$this->_importe= $precio;
		}

		function Mostrar()
		{
			echo "Patente: $this->_patente  | Ingreso: $this->_ingreso | Importe: $this->_importe <br />";
		}

		function toArray()
		{
			$retorno= array();

			array_push($retorno, $this->_patente);
			array_push($retorno, $this->_ingreso);
			array_push($retorno, $this->_importe);

			return $retorno;
		}

		static function Leer()
		{
			$archivo= fopen("Vehiculo.txt", "r");
			$retorno= array();

			while(!feof($archivo))
			{
				//echo "<br /> Hola";
				$renglon= fgets($archivo);
				
				$arraydeDatos= explode(',', $renglon); 

				$vehiculo1= new Vehiculo($arraydeDatos[0], $arraydeDatos[1], $arraydeDatos[2]);
				//var_dump($arraydeDatos);
				
				//echo $renglon . '<br />';

				array_push($retorno, $vehiculo1);

				
			}

			fclose($archivo);
			
			return $retorno;
		}

		static function Guardar(Vehiculo $unVehiculo)
		{
			$archivo= fopen("Vehiculo.txt", "a");
			$retorno= array();

			$arraydeDatos= implode(',', $unVehiculo->toArray());

			fputs($archivo, $arraydeDatos . "\n");

			fclose($archivo);

			return $retorno;

		}


	}
	

 ?>