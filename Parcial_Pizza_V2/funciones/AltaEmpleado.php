<?php

if(isset($_POST['email']) && isset($_POST['alias']) && isset($_POST['tipo']) && isset($_POST['edad']) && isset($_FILES['imagen']))
{
    $email = $_POST['email'];
    $alias = $_POST['alias'];
    $tipo = $_POST['tipo'];
    $edad= $_POST['edad'];
    $imagen = $_FILES['imagen'];

    if($tipo == "vendedor" || $tipo == "encargado" || $tipo == "repartidor")
    {
        if($alias == "cuchu" || $alias == "pachi" || $alias == "nacho" || $alias == "tacho")
        {
            $unEmpleado = new Empleado(1, $email, $alias, $tipo, $edad);
            if($unEmpleado->Guardar($RUTA_EMPLEADOS))
            {
                if($unEmpleado->CargarImagen($imagen, $RUTA_CARPETA_IMAGENES_EMPLEADOS))
                    echo "SE DIO DE ALTA EMPLEADO CON IMAGEN.";
                else
                {
                    $unEmpleado->BorrarEmpleado($RUTA_EMPLEADOS, $unEmpleado);
                    echo "No se pudo cargar con imagen.";
                }
            }
            else
                echo "No se pudo guardar.";
        }
        else
            echo 'Error cargue "alias" como "cuchu", "pachi", "nacho" o "tacho"..';
    }
    else
        echo 'Error cargue "tipo" como "vendedor", "encargado" o "repartidor".';
    
}
else
    echo 'Error cargue "email", "alias", "tipo", "cantidad" y "imagen".';
?>