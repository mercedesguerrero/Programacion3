<?php

require_once "Clases/pedido.php";
require_once "Clases/proveedor.php";

$RUTA_PROVEEDORES="Archivos/proveedores.txt";
$RUTA_PEDIDOS="Archivos/pedidos.txt";

if(isset($_POST['producto']) && isset($_POST['cantidad']) && isset($_POST['idProveedor'])){
	
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $idProveedor = $_POST['idProveedor'];

        if(!$proveedor = Proveedor::TraerProveedorPorId($RUTA_PROVEEDORES, $idProveedor)){
			
            echo '<br/>No existe el idProveedor: '.$idProveedor;
            die;
        }else{
			
         $pedido = new Pedido($producto, $cantidad, $idProveedor);
         	
		if($pedido->Guardar($RUTA_PEDIDOS)){
			
        	echo "<br/>Exito.";
        }else{
			echo "<br/>Error al guardar en el archivo.";
         }
        }
}
else
{
	echo '<br/>Error cargue "producto", "cantidad" y "idProveedor".';
}

?>