<?php
if(isset($_POST['email']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantidadKg']) && isset($_FILES['imagen']))
{
    $email = $_POST['email'];
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];
    $cantidadKg = $_POST['cantidadKg'];
    $imagen = $_FILES['imagen'];
    if($tipo == "crema" || $tipo == "agua")
    {
        if($sabor == "chocolate" || $sabor == "dulcedeleche" || $sabor == "frutilla")
        {
            $idStock = Helado::TraerIdStock($RUTA_HELADOS, $sabor, $tipo, $cantidadKg);
            if($idStock != null)
            {
                $unHelado = Helado::TraerHeladoPorId($RUTA_HELADOS, $idStock);
                if($unHelado != null)
                {
                    if($unHelado->Vender($RUTA_HELADOS, $cantidadKg))
                    {
                        $venta = new Venta(1, $email, $sabor, $tipo, $cantidadKg);
                        if($venta->Guardar($RUTA_VENTAS))
                        {
                            if($venta->CargarImagen($imagen, $RUTA_CARPETA_IMAGENES_VENTAS))
                                echo "Exito.";
                            else
                            {
                                $venta->BorrarVenta($RUTA_VENTAS);
                                echo "Fallo.";
                            }
                        }
                        else
                            echo "Fallo.";
                    }
                    else
                        echo "Fallo.";
                }
                else
                    echo "Fallo.";
            }
            else
                echo "No hay stock.";
        }
        else
            echo 'Error cargue "sabor" como "chocolate", "dulcedeleche" o "frutilla".';
    }
    else
        echo 'Error cargue "tipo" como "crema" o "agua".';
    
}
else
    echo 'Error cargue "email", "sabor", "tipo", "cantidad" y "imagen".';
?>