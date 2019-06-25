<?php
require_once "Clases/pedido.php";
require_once "Clases/proveedor.php";

$RUTA_PEDIDOS="Archivos/pedidos.txt";
$RUTA_PROVEEDORES="Archivos/proveedores.txt";

if(isset($_GET['idProveedor'])){
	
    $idProveedor = $_GET['idProveedor'];
    $pedidos = Pedido::TraerPedidosPorIdDelProveedor($RUTA_PEDIDOS, $RUTA_PROVEEDORES, $idProveedor);
		if(!$pedidos){
			
			echo "<br/>No hay pedidos cargados con el id ".$idProveedor.".";
		}else{
			
			echo Pedido::PedidosToTable($pedidos);
		}
}
else
{
    echo '<br/>Error cargue "idProveedor" para poder buscar por proveedor.';
}




?>