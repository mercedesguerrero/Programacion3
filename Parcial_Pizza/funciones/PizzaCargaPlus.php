<?php
if(isset($_PUT['sabor']) && isset($_PUT['precio']) && isset($_PUT['tipo']) && isset($_PUT['cantUnidades']))
{
    $sabor = $_PUT['sabor'];
    $precio = $_PUT['precio'];
    $tipo = $_PUT['tipo'];
    $cantUnidades = $_PUT['cantUnidades'];
    if($tipo == "molde" || $tipo == "piedra")
    {
        if($sabor == "muzza" || $sabor == "jamon" || $sabor == "especial" || $sabor == "pistacho")
        {
            $pizza = new Pizza(1, $sabor, $precio, $tipo, $cantUnidades);
            if(Pizza::ExistePizzaPorSaborYTipo($RUTA_PIZZA, $sabor, $tipo))
            {
                if(Pizza::ModificarStockYPrecio($RUTA_PIZZA, $sabor, $tipo, $precio, $cantUnidades))
                {
                    echo "<br/>Se mofificó precio y cantidad.";
                }
                else
                    echo "No se pudo modificar la pizza.";

            }
            else
            {
                if($pizza->Guardar($RUTA_PIZZA))
                {
                    echo "Se guardo la pizza.";
                }
                else
                    echo "No se pudo guardar la pizza.";
            }
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