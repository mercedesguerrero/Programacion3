<?php
if(isset($_PUT['email']) && isset($_PUT['tipo']))
{
    $email = $_PUT['email'];
    $tipo = $_PUT['tipo'];
    
    if($tipo == "vendedor" || $tipo == "encargado" || $tipo == "repartidor")
    {
            if(Empleado::ExisteEmpleadoPorEmail($RUTA_EMPLEADOS, $email))
            {
                if(Empleado::ModificarTipo($RUTA_EMPLEADOS, $email, $tipo))
                {
                    echo "<br/>Se mofificó tipo.";
                }
                else
                    echo "No se pudo modificar la pizza.";

            }
            else
            {
                echo "No existe ese empleado.";
            }
        
    }
    else
        echo 'Error cargue "tipo" como "vendedor", "encargado" o "repartidor".';
}
else
    echo 'Error cargue "email" y "tipo".';
?>