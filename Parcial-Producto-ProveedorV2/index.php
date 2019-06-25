<?php

$dato = $_SERVER['REQUEST_METHOD'];

    switch ($dato) 
    {
        case 'POST':

            switch($_POST['caso'])
            {   
                case 'cargarProveedor' :
                include "Funciones/cargarProveedor.php";
                break;

                case 'hacerPedido' :
                include "Funciones/hacerPedido.php";
                break;

                case 'modificarProveedor' :
                include "Funciones/modificarProveedor.php";
                break;
            }
                    
            break;
        
        case 'GET':
            
            switch($_GET['caso'])
            {
                case 'consultarProveedor':
                include "Funciones/consultarProveedor.php";
                break;

                case 'proveedores':
                include "Funciones/todosLosProveedores.php";
                break;

                case 'listarPedidos' :
                include "Funciones/listarPedidos.php";
                break;

                case 'listarPedidoProveedor':
                include "Funciones/listarPedidoProveedor.php";
                break;

                case 'fotosBack':
                include "Funciones/fotosBack.php";
                break;
            }
        break;
            
    }

?>