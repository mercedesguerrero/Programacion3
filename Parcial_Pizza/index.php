<?php
require_once 'clases/Pizza.php';
require_once 'clases/Venta.php';

$RUTA_PIZZA="./archivos/Pizza.txt";
$RUTA_VENTAS="./archivos/Venta.txt";
$RUTA_CARPETA_IMAGENES_VENTAS = "./imagenesDeLaVenta/";
$RUTA_CARPETA_IMAGENES = "./imagenesDePizza/";

$content= file_get_contents("php://input");

$caso = $_SERVER['REQUEST_METHOD'];
echo $caso . "<br>";

switch ($caso) 
{
  case "GET":
        switch (key($_GET)) {
            case 'pizzacarga':
                include "funciones/PizzaCarga.php";
                break;
        }
        break; 
    case "POST":
        switch (key($_POST)) {
            case 'pizzacargaconimagen'://POST funciona ok
                include "funciones/PizzaCargaConImagen.php";
                break;    
            case 'pizzaconsultar':
                include "funciones/PizzaConsultar.php";
                break;
            case 'altaventa':
                include "funciones/AltaVenta.php";
                break;
            case 'altaventaconimagen'://POST funciona ok
                include "funciones/AltaVentaConImagen.php";
                break;
        }
        break;
    
}     

?>