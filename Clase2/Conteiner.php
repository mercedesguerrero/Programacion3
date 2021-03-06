<?php 

	class Conteiner{

		//require_once "Producto.php";

		private $_id;
		private $_capacidad;
		private $_tamanio;
		private $_listaDeProductos;

		function __construct($id, $capacidad, $tamanio)
		{
			$this->_id= $id;
			$this->_capacidad= $capacidad;
			$this->_tamanio= $tamanio;
			$this->_listaDeProductos= array();
		}

		function setCapacidad($capacidad)
		{
			$this->_capacidad= $capacidad;
		}

		function MostrarContainer()
		{
			echo "<div>" . "Id conteiner: " . $this->_id . " | Capacidad: " . $this->_capacidad . " | Tamaño: " . $this->_tamanio . "</div>";
		}

		function MostrarContenido()
		{
			foreach ($this->$_listaDeProductos as $producto) {

				echo Producto::MostrarProducto($producto);
			}

		}

		function AgregarProducto($unProducto)
		{

			if($this->existeProducto($unProducto) && $this->hayKilosLibres($unProducto))
			{
				$this->setCapacidad($this->_capacidad - $unProducto->_kilos);
			}
			else if(!$this->existeProducto($unProducto) && $this->hayKilosLibres($unProducto))
			{
				array_push($this->_listaDeProductos, $unProducto);
			}
			else
			{
				echo "<div>" . "No hay lugar en el conteiner" . "</div>";
			}
		}

		function existeProducto($unProducto)
		{
			return in_array($unProducto, $this->$_listaDeProductos);
		}

		function hayKilosLibres($unProducto)
		{
			$retorno= FALSE;

			if ($this->_capacidad >= $unProducto->getKilos()) 
			{
				$retorno= TRUE;
			}

			return $retorno;
		}

	}
	

 ?>