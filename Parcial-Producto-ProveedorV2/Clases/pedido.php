<?php
require_once 'Clases/proveedor.php';
class Pedido
{
    public $producto;
    public $cantidad;
    public $proveedor;

    function __construct($producto, $cantidad, $proveedor)
    {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->proveedor = $proveedor;
    }

    public function RetornarJson()
    {
        
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    //---------------------------------------------------GUARDAR PEDIDO PASAN DOS RUTAS ----------------------------------------------------------
    public function Guardar($rutaPedidos)
    {
        echo "Entro EN GUARDAR";
        if(file_exists($rutaPedidos))
        {
           $archivo=fopen($rutaPedidos,"a");
           return fwrite($archivo,$this->RetornarJson().PHP_EOL);
        }
        //sino existe el ARCHIVO, SE CREA Y SE GUARDA
        $archivo=fopen($rutaPedidos,"w");
        return fwrite($archivo,$this->RetornarJson().PHP_EOL);



    }
    //-------------------------------------------------------------------------------------------------------------------------------------------------

    //----------------------------------------------MOSTRAR TABLAPEDIDOS --------------------------------------------------------------------------------

    
    public static function MostrarTablaPedidos($rutaPedidos, $rutaProveedores)
    {
        $pedidos = self::Cargar($rutaPedidos, $rutaProveedores);
        if(!$pedidos || $pedidos == "NADA")
            return "<br/>No hay pedidos cargados.";
        else
            return self::PedidosToTable($pedidos);
    }
    

    public static function Cargar($rutaPedidos, $rutaProveedores)
    {
        $retorno = false;
        if(file_exists($rutaPedidos))
        {
            $arch = fopen($rutaPedidos, "r");
            $pedidos = array();
            while(!feof($arch))
            {
                $linea = fgets($arch);
                if($linea != "")
                {
                    $stdObj = json_decode($linea);
                    if(!$stdObj->proveedor = Proveedor::TraerProveedorPorId($rutaProveedores, $stdObj->proveedor))
					
                    {
						
						var_dump($stdObj);
                        echo '<br/>Error al cargar . No existe el idProveedor.';
                        die;
                    }
                    $pedido = new Pedido($stdObj->producto, $stdObj->cantidad, $stdObj->proveedor);
                    array_push($pedidos, $pedido);
                }
            }
            if(count($pedidos) < 1)
                return "NADA";
            fclose($arch);
            return $pedidos;
        }
        return $retorno;
    }



    //------------------------------------------------------PEDIDOS TO TABLE-------------------------------------------------------------------------
    public static function PedidosToTable($pedidos)
    {
        $texto = "<table border='1'>";
        $texto .= "<thead bgcolor='lightgrey'>";
        $texto .= "<tr>";
        $texto .= "<th>Producto</th>";
        $texto .= "<th>Cantidad</th>";
        $texto .= "<th>idProveedor</th>";
        $texto .= "<th>nombreProveedor</th>";
        $texto .= "</tr>";
        $texto .= "</thead>";
        $texto .= "<tbody>";
        foreach ($pedidos as $pedido)
        {
            $texto .= "<tr>";
            $texto .= "<td>".$pedido->producto."</td>";
            $texto .= "<td>".$pedido->cantidad."</td>";
            $texto .= "<td>".$pedido->proveedor->id."</td>";
            $texto .= "<td>".$pedido->proveedor->nombre."</td>";
            $texto .= "</tr>";
        }
        $texto .= "</tbody>";
        $texto .= "</table>";
        return $texto;
    }
    //----------------------------------------------------------------------------------------------------------------------------------------------
    
    //---------------------------------------------TRAER PEDIDOS POR ID DEL PROVEEDOR--------------------------------------------------------------

    public static function TraerPedidosPorIdDelProveedor($rutaPedidos, $rutaProveedores, $id)
    {
        $miProveedor = Proveedor::TraerProveedorPorId($rutaProveedores, $id);
        $pedidos = self::Cargar($rutaPedidos, $rutaProveedores);
        if(!$miProveedor || !$pedidos || $pedidos == "NADA")
            return false;
        $misPedidos = array();
        foreach ($pedidos as $pedido)
        {
            if($pedido->proveedor->id == $miProveedor->id)
                array_push($misPedidos, $pedido);
        }
        if(count($misPedidos) >= 1)
            return $misPedidos;
        return false;
    }
    //------------------------------------------------------------------------------------------------------------------------------------------------------
}

?>