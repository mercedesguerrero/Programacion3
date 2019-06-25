<?php

    if(isset($_DELETE['sabor']) && isset($_DELETE['tipo']))
    {
        $sabor = $_DELETE['sabor'];
        $tipo = $_DELETE['tipo'];


        $pizzaABorrar = Pizza::DevuelvePizzaxSaboryTipo($RUTA_PIZZA, $sabor, $tipo);

        if($pizzaABorrar != null)
        {  
            if($pizzaABorrar->MoverImgABackUp($RUTA_IMAGENES_BACKUP, $RUTA_CARPETA_IMAGENES, $RUTA_PIZZA))
            {
                if($pizzaABorrar->BorrarPizza($RUTA_PIZZA, $pizzaABorrar)!=null)
                {
                    echo "Se guardo la imagen en Backup y se borro del archivo.";
                }
                else
                {
                    echo "No se pudo borrar.";
                }
            }
            else
            {
                echo "No se pudo guardar la imagen en backup.";
            }
        }
    }
    else
    {
        echo "No hay pizza de " . $sabor . " y tipo" . $tipo;
    }
?>