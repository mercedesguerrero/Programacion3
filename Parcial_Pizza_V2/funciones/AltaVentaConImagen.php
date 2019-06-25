<?php
if(isset($_POST['email']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantUnidades']) && isset($_FILES['imagen']))
{
    $email = $_POST['email'];
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];
    $cantUnidades= $_POST['cantUnidades'];
    $imagen = $_FILES['imagen'];

    if($tipo == "molde" || $tipo == "piedra")
    {
        if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial" || $sabor == "pistacho")
        {
            $idStock = Pizza::TraerIdStock($RUTA_PIZZA, $sabor, $tipo, $cantUnidades);
            if($idStock != null)
            {
                $unaPizza = Pizza::TraerPizzaPorId($RUTA_PIZZA, $idStock);
                if($unaPizza != null)
                {
                    if($unaPizza->Vender($RUTA_PIZZA, $cantUnidades))
                    {
                        $venta = new Venta(1, $email, $sabor, $tipo, $cantUnidades);

                        if($venta->Guardar($RUTA_VENTAS))
                        {
                            if($venta->CargarImagen($imagen, $RUTA_CARPETA_IMAGENES_VENTAS))
                                echo "Se cargo la venta con imagen.";
                            else
                            {
                                $venta->BorrarVenta($RUTA_VENTAS);
                                echo "No se cargo la venta.";
                            }
                        }
                        else
                            echo "No se pudo guardar.";
                    }
                    else
                        echo "No se pudo vender.";
                }
                else
                    echo "No se encontro.";
            }
            else
                echo "No hay stock.";
        }
        else
            echo 'Error cargue "sabor" como "muzza", "jamon", "especial" o "pistacho"..';
    }
    else
        echo 'Error cargue "tipo" como "molde" o "piedra".';
    
}
else
    echo 'Error cargue "email", "sabor", "tipo", "cantidad" y "imagen".';
?>