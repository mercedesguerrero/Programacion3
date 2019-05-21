<?php 

	class ManejadorDeArchivos{


		static function CambiarNombre($destino, $nombre, $extension)
		{

			return "archivos/" . $nombre . "." . $extension;
		}

		static function MoveraBackup($nombre, $extension)
		{
			$fecha= date("Y-m-d H:i:s");
			
			return "BACKUP/" . $nombre . $fecha . $extension;
		}

		static function hacerMarcaDeAgua($destino)
		{

		}


	}
	

 ?>