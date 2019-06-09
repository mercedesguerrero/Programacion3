<?php 

	class Producto{
		private $_idProd;
		private $_nombre;
		private $_importador;
		private $_pais;
		private $_kilos;

		function __construct($id, $nombre, $importador, $pais, $kilos)
		{
			$this->_idProd= $id;
			$this->_nombre= $nombre;
			$this->_importador= $importador;
			$this->_pais= $pais;
			$this->_kilos= $kilos;
		}

		function getId()
		{
			return $this->$_idProd;
		}

		function getKilos()
		{
			return $this->$_kilos;
		}

		function MostrarProducto()
		{
			echo "<div>" . "Id producto: " . $unProducto->_idProd . " | Nombre: " . $unProducto->_nombre . " | Importador: " . $unProducto->_importador . " | Pais: " . $unProducto->_pais . " | Kilos: " . $unProducto->_kilos . "</div>";
		}




	}
	



 ?>