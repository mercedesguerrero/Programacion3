<?php

if(isset($_GET['mostrarFotos']))
{
    $mostrar = $_GET['mostrarFotos'];

    switch ($mostrar) {
        case 'fotosCargadas':
            echo "<div align='left'><h1>Pizzas:</h1></div>"  ;
            echo Pizza::ImgPizzasEnTabla($RUTA_CARPETA_IMAGENES);
            break;
        
        case 'fotosBorradas':
            echo "<div align='left'><h1>Pizzas borradas:</h1></div>"  ;
            echo Pizza::ImgPizzasEnTabla($RUTA_IMAGENES_BACKUP);
            break;
    }   
}
else
    echo 'Error cargue "mostrarFotos".';
?>