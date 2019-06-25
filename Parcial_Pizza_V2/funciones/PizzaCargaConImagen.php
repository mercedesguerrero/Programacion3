<?php
if(isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantUnidades']) && isset($_FILES['imagen']))
{
    $sabor = $_POST['sabor'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $cantUnidades = $_POST['cantUnidades'];
    $imagen = $_FILES['imagen'];
    if($tipo == "molde" || $tipo == "piedra")
    {
        if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial" || $sabor == "pistacho")
        {
            $unaPizza = new Pizza(1, $sabor, $precio, $tipo, $cantUnidades);
            if($unaPizza->Guardar($RUTA_PIZZA))
            {
                if($unaPizza->CargarImagen($imagen, $RUTA_CARPETA_IMAGENES))
                    echo "SE CARGO LA PIZZA CON IMAGEN.";
                else
                {
                    $unaPizza->BorrarPizza($RUTA_PIZZA);
                    echo "No se pudo cargar con imagen.";
                }
            }
            else
                echo "No se pudo guardar.";
        }
        else
            echo 'Error cargue "sabor" como "muzza", "jamon", "especial" o "pistacho".';
    }
    else
        echo 'Error cargue "tipo" como "molde" o "piedra".';
}
else
    echo 'Error cargue "sabor", "precio", "tipo", "cantidad" y "imagen".';
?>