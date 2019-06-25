<?php
require_once 'clases/Pizza.php';
require_once 'clases/Venta.php';

$RUTA_PIZZA="./archivos/Pizza.txt";
$RUTA_VENTAS="./archivos/Venta.txt";
$RUTA_CARPETA_IMAGENES_VENTAS = "./imagenesDeLaVenta/";
$RUTA_CARPETA_IMAGENES = "./imagenesDePizza/";
$RUTA_IMAGENES_BACKUP = "./backUpFotos/";

$content= file_get_contents("php://input");

$method = $_SERVER['REQUEST_METHOD'];
echo $method . "<br>";

switch ($method) 
{
    case "GET":
        switch (key($_GET)) {
            case 'pizzacarga':
                include "funciones/PizzaCarga.php";
                break;
            case 'mostrarFotos':
                include "funciones/ListadoDeImagenes.php";
                break;
        }
        break; 
    case "POST":
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
        }
        break;
    case "PUT":
        parse_str($content, $_PUT);
        include "funciones/PizzaCargaPlus.php";
        break;
    case 'DELETE':
        parse_str($content, $_DELETE);
        include "funciones/BorrarPizza.php";
        break;
    
}     

?>