<?php

require_once "Clases/proveedor.php";

echo "<br>consultarProveedor.php (por NOMBRE)<br/>";

if(isset($_GET['nombre'])){
	
	$nombre=$_GET['nombre'];
	$proveedor= proveedor::TraerProveedorPorNombre("Archivos/proveedores.txt",$nombre);
    
    if($proveedor == true){
		
        echo $proveedor->ToString();
    }else{
		echo "El proveedor ".$nombre. " no se encuentra en la lista Proveedores.txt";
    }
}

else
{
    echo "FALTAN DATOS";
}



?>