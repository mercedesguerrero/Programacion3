<?php
require_once 'clases/Pizza.php';
require_once 'clases/Venta.php'

$RUTA_PIZZA="./archivos/Pizza.txt";
$RUTA_VENTAS="./archivos/Venta.txt";

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
            case 'pizzaconsultar':
                include "funciones/PizzaConsultar.php";
                break;
            case 'altaventa':
                include "funciones/AltaVenta.php";
                break;
        }
        break;
    
}     

?>