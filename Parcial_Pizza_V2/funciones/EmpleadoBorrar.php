<?php

    if(isset($_DELETE['email']) && isset($_DELETE['tipo']))
    {
        $email = $_DELETE['email'];
        $tipo = $_DELETE['tipo'];
        $empleadosABorrar = array();


        $empleadosABorrar = Empleado::DevuelveEmpleadoPorMailoTipo($RUTA_EMPLEADOS, $email, $tipo);
        var_dump($empleadosABorrar);

        foreach ($empleadosABorrar as $empleadoABorrar) {
            if($empleadoABorrar != null)
            {  
                //if($empleadoABorrar->MoverImgABackUp($RUTA_IMAGENES_BACKUP_EMP, $RUTA_CARPETA_IMAGENES_EMPLEADOS, $RUTA_EMPLEADOS))
                //{
                    if($empleadoABorrar->BorrarEmpleado($RUTA_EMPLEADOS, $empleadoABorrar)!=null)
                    {
                        echo "Se guardo la imagen en Backup y se borro del archivo.";
                    }
                    else
                    {
                        echo "No se pudo borrar.";
                    }
                }
                //else
                //{
                  //  echo "No se pudo guardar la imagen en backup.";
                //}
            //}
            
        }

        
    }

    if(isset($_DELETE['email']) && !isset($_DELETE['tipo']))
    {
        $email = $_DELETE['email'];
        $empleadosABorrar = array();


        $empleadosABorrar = Empleado::DevuelveEmpleadoPorMail($RUTA_EMPLEADOS, $email);
        var_dump($empleadosABorrar);

        foreach ($empleadosABorrar as $empleadoABorrar) {
            if($empleadoABorrar != null)
            {  
                //if($empleadoABorrar->MoverImgABackUp($RUTA_IMAGENES_BACKUP_EMP, $RUTA_CARPETA_IMAGENES_EMPLEADOS, $RUTA_EMPLEADOS))
                //{
                    if($empleadoABorrar->BorrarEmpleado($RUTA_EMPLEADOS, $empleadoABorrar)!=null)
                    {
                        echo "Se borro del archivo.";
                    }
                    else
                    {
                        echo "No se pudo borrar.";
                    }
                }
                //else
                //{
                  //  echo "No se pudo guardar la imagen en backup.";
                //}
            //}
            
        }

        
    }

    if(!isset($_DELETE['email']) && isset($_DELETE['tipo']))
    {
        $tipo = $_DELETE['tipo'];
        $empleadosABorrar = array();


        $empleadosABorrar = Empleado::DevuelveEmpleadoPorTipo($RUTA_EMPLEADOS, $tipo);
        var_dump($empleadosABorrar);

        foreach ($empleadosABorrar as $empleadoABorrar) {
            if($empleadoABorrar != null)
            {  
                //if($empleadoABorrar->MoverImgABackUp($RUTA_IMAGENES_BACKUP_EMP, $RUTA_CARPETA_IMAGENES_EMPLEADOS, $RUTA_EMPLEADOS))
                //{
                    if($empleadoABorrar->BorrarEmpleado($RUTA_EMPLEADOS, $empleadoABorrar)!=null)
                    {
                        echo "Se borro del archivo.";
                    }
                    else
                    {
                        echo "No se pudo borrar.";
                    }
                }
                //else
                //{
                  //  echo "No se pudo guardar la imagen en backup.";
                //}
            //}
            
        }

        
    }
    else
    {
        echo "No hay empleado con email: " . $email . " y tipo: " . $tipo;
    }
?>