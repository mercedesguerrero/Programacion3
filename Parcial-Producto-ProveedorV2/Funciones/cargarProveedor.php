<?php
require_once "Clases/Proveedor.php";
$RUTA_PROVEEDORES="Archivos/proveedores.txt";

if(isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['email']) && isset($_FILES['foto'])){
	
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = strtolower($_POST['email']);
    $foto = $_FILES['foto'];
	
    if(!$extension = Proveedor::TraerExtensionFoto($foto)){
		
		echo '<br/>Error: el formato de "foto" debe ser "jpg" o "png".';
        die;
    }
    
	$proveedor = new Proveedor($id, $nombre, $email, $id."_".strtolower($nombre).$extension);

    //VERIFICA SI SE ENCUENTRA EL ID DEL PROVEEDOR
    $estaproveedor=Proveedor::TraerProveedorPorID($RUTA_PROVEEDORES,$id);

    if($estaproveedor==true){
		
        echo "El PROVEEDOR EXISTE";

    }else{//SINO ESTA SE GUARDA FOTO Y PROVEEDOR
  
         echo   $proveedor->Guardar($RUTA_PROVEEDORES)?"<br/>Éxito":"<br/>Falló";
                $proveedor->CargarFoto($foto);
    }
      
    }else{
		
        echo '<br/>Error cargue "id", "nombre", "email" y "foto".';
    }

?>