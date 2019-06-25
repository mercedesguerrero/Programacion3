<?php
if(isset($_GET['sabor']) && isset($_GET['precio']) && isset($_GET['tipo']) && isset($_GET['cantUnidades']))
{
    $sabor = $_GET['sabor'];
    $precio = $_GET['precio'];
    $tipo = $_GET['tipo'];
    $cantUnidades = $_GET['cantUnidades'];
    if($tipo == "molde" || $tipo == "piedra")
    {
        if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial" || $sabor == "pistacho")
        {
            $pizza = new Pizza(1, $sabor, $precio, $tipo, $cantUnidades);
            if($pizza->Guardar($RUTA_PIZZA))
            {
                echo "Se guardo la pizza.";
            }
            else
                echo "No se pudo guardar la pizza.";
        }
        else
            echo 'Error cargue "sabor" como "muzza", "jamon", "especial" o "pistacho".';
    }
    else
        echo 'Error cargue "tipo" como "molde" o "piedra".';
}
else
    echo 'Error cargue "sabor", "precio", "tipo" y "cantidad".';
?>