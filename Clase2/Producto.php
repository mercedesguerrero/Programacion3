<?php 

	class Producto{
		private $_id;
		private $_nombre;
		private $_importador;
		private $_pais;
		private $_kilos;

		function __construct($id, $nombre, $importador, $pais, $kilos)
		{
			$this->_id= $id;
			$this->_nombre= $nombre;
			$this->_importador= $importador;
			$this->_pais= $pais;
			$this->_kilos= $kilos;
		}

		function Mostrar()
		{
			echo "<div>" . "Id producto: " . $unProducto->_id . " | Nombre: " . $unProducto->_nombre . " | Importador: " . $unProducto->_importador . " | Pais: " . $unProducto->_pais . " | Kilos: " . $unProducto->_kilos . "</div>";
		}


	}
	



 ?>