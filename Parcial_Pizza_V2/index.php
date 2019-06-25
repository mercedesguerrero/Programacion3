<?php
require_once 'clases/Pizza.php';
require_once 'clases/Venta.php';
require_once 'clases/Empleados.php';

$RUTA_PIZZA="./archivos/Pizza.txt";
$RUTA_VENTAS="./archivos/Venta.txt";
$RUTA_EMPLEADOS="./archivos/Empleados.txt";
$RUTA_CARPETA_IMAGENES_VENTAS = "./imagenesDeLaVenta/";
$RUTA_CARPETA_IMAGENES_EMPLEADOS = "./imagenesDeEmpleados/";
$RUTA_CARPETA_IMAGENES = "./imagenesDePizza/";
$RUTA_IMAGENES_BACKUP = "./backUpFotos/";
$RUTA_IMAGENES_BACKUP = "./backUpFotosEmpleados/";

$content= file_get_contents("php://input");

$method = $_SERVER['REQUEST_METHOD'];
echo $method . "<br>";

switch ($method) 
{
    case "GET":
    //var_dump($_GET);
        switch (key($_GET)) {
            case 'pizzacarga':
                include "funciones/PizzaCarga.php";
                break;
            case 'mostrarFotos':
                include "funciones/ListadoDeImagenes.php";
                break;
            case 'mostrarEmpleados':
                include "funciones/ListadoDeEmpleados.php";
                break;
        }
        break; 
    case "POST":
    //var_dump($_POST);
        switch (key($_POST)) {
            case 'pizzacargaconimagen'://POST
                include "funciones/PizzaCargaConImagen.php";
                break;    
            case 'pizzaconsultar':
                include "funciones/PizzaConsultar.php";
                break;
            case 'altaventa':
                include "funciones/AltaVenta.php";
                break;
            case 'altaventaconimagen'://POST
                include "funciones/AltaVentaConImagen.php";
                break;
            case 'altaempleado'://POST
                include "funciones/AltaEmpleado.php";
                break;
        }
        break;
    case "PUT":
        parse_str($content, $_PUT);
        //include "funciones/PizzaCargaPlus.php";
        include "funciones/EmpleadoDatos.php";
        break;
    case 'DELETE':
        parse_str($content, $_DELETE);
        //include "funciones/BorrarPizza.php";
        include "funciones/EmpleadoBorrar.php";
        break;
    
}     

?>