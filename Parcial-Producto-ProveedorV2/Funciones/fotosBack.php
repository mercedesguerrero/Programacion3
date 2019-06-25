<?php
require_once "Clases/pedido.php";
require_once "Clases/proveedor.php";
$RUTA_PEDIDOS="Archivos/pedidos.txt";
$RUTA_PROVEEDORES="Archivos/proveedores.txt";
$DIR_PROVEEDORES_FOTOS_BACKUP = "backUpFotos/";

echo Proveedor::MostrarTablaFotosBackUp($RUTA_PROVEEDORES, $DIR_PROVEEDORES_FOTOS_BACKUP);

?>