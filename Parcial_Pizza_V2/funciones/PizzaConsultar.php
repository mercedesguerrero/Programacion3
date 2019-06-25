<?php
if(isset($_POST['sabor']) && isset($_POST['tipo']))
{
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];
    $respuesta = Pizza::ExistePizzaPorSaborYTipo($RUTA_PIZZA, $sabor, $tipo);
    $respuestaSabor = Pizza::ExistePizzaPorSabor($RUTA_PIZZA, $sabor);

    if($respuesta)
    {
        echo "Si, Hay.";
    }
    else{
        if($respuestaSabor)
        {
            echo "Hay Pizza con sabor " . $sabor . " pero no del tipo " . $tipo . ".";
        }
        else
        {
            echo "No hay de esa Pizza.";
        }
    }
}
else
{
    echo 'Error cargue "sabor" y "tipo".';
}
?>