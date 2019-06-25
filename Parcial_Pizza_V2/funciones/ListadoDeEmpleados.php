<?php

if(isset($_GET['mostrarEmpleados']))
{
    $mostrar = $_GET['mostrarEmpleados'];

    switch ($mostrar) {
        case 'listadoConImagenes':
            echo "<div align='left'><h1>Empleados con foto:</h1></div>"  ;
            echo Empleado::ImgEmpleadosEnTabla($RUTA_CARPETA_IMAGENES_EMPLEADOS);
            break;
        
        case 'listadoSinImagenes':
            echo "<div align='left'><h1>Empleados:</h1></div>"  ;
            echo Empleado::listarEmpleados($RUTA_EMPLEADOS);
            break;

        case 'soloNombres':
            echo "<div align='left'><h1>Nombres empleados:</h1></div>"  ;
            echo Empleado::listarSoloNombres($RUTA_EMPLEADOS);
            break;
    }   
}
else
    echo 'Error cargue "mostrarFotos".';
?>