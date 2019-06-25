<?php

echo "Mostrar Todos Lor Proveedores (GET)";
require_once "Clases/proveedor.php";

  if($proveedores = proveedor::Cargar("Archivos/proveedores.txt")){
	  
      echo "<h3>Listado de Proveedores </h3>";
      foreach ($proveedores as $proveedor){
		  
		  echo $proveedor->ToString()."<br/>";
	  }
  }else{
	  
      echo "<br/>NO EXISTE un proveedor, DEBE CREAR PRIMERO UN proveedor PARA PODER VER EL LISTADO.";
  }




?>