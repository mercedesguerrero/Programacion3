<?php
require_once './clases/Pizza.php';

class Venta
{
    public $id;
    public $email;
    public $sabor;
    public $tipo;
    public $cantUnidades;

    function __construct($id, $email, $sabor, $tipo, $cantUnidades)
    {
        $this->id = $id;
        $this->email = $email;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantUnidades = $cantUnidades;
    }


    public function Guardar($ruta)
    {
        $ventas = self::Cargar($ruta);
        if($ventas != null)
        {
            $maxId = self::TraerMayorId($ventas);
            $this->id = $maxId + 1;
            if(!self::ExisteVentaEnLista($ventas, $this))
            {
                if(file_exists($ruta))
                {
                    $archivo = fopen($ruta, "a");
                    return fwrite($archivo, $this->DevolverJson().PHP_EOL);
                }
                $archivo = fopen($ruta, "w");
                return fwrite($archivo, $this->DevolverJson().PHP_EOL);
            }
        }
        else
        {
            if(file_exists($ruta))
            {
                $archivo = fopen($ruta, "a");
                return fwrite($archivo, $this->DevolverJson().PHP_EOL);
            }
            $archivo = fopen($ruta, "w");
            return fwrite($archivo, $this->DevolverJson().PHP_EOL);
        }
        return false;
    }

    public function DevolverJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    public static function GuardarTodo($ventas, $ruta)
    {
        if(file_exists($ruta))
        {
            foreach ($ventas as $key => $pi)
            {
                if($key == 0)
                {
                    $archivo = fopen($ruta, "w");
                    fwrite($archivo, json_encode($ventas[0]).PHP_EOL);
                    fclose($archivo);
                }
                else
                {
                    $archivo = fopen($ruta, "a");
                    fwrite($archivo, json_encode($ventas[$key]).PHP_EOL);
                    fclose($archivo);
                }
            }
            return true;
        }
        return false;
    }

    public static function Cargar($ruta)
    {
        if(file_exists($ruta))
        {
            $archivo = fopen($ruta, "r");
            $ventas = array();
            while(!feof($archivo))
            {
                $linea = fgets($archivo);
                if($linea != "")
                {
                    $objeto = json_decode($linea);
                    if(isset($objeto)!=null)
                    {
                        $venta = new Venta($objeto->id, $objeto->email, $objeto->sabor, $objeto->tipo, $objeto->cantUnidades);
                        array_push($ventas, $venta);
                    }
                    
                }
            }
            fclose($archivo);
            if(count($ventas) > 0)
                return $ventas;
        }
        return null;
    }

    private static function ExisteVentaEnLista($ventas, $venta)
    {
        foreach ($ventas as $vendido)
        {
            if($vendido->id == $venta->id)
                return true;
        }
        return false;
    }

    public static function TraerVentaPorId($ruta, $id)
    {
        $ventas = self::Cargar($ruta);
        if($ventas != null)
        {
            foreach ($ventas as $vendido)
            {
                if($vendido->id == $id)
                    return $vendido;
            }
        }
        return null;
    }

    
    public function CargarImagen($files, $rutaCarpetaImagenes)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $mail= explode("@", $this->email);
                $nombreDelArchivoImagen = $this->tipo."_".strtolower($this->sabor)."_".$mail[0]."_".date('Ymd').$extension;
                $rutaCompletaImagen = $rutaCarpetaImagenes.$nombreDelArchivoImagen;
                return move_uploaded_file($files["tmp_name"], $rutaCompletaImagen);
            }
        }
        return false;
    }

    public static function TraerExtensionImagen($files)
    {
        switch ($files["type"])
        {
            case 'image/jpeg':
                $extension = ".jpg";
                break;
            case 'image/png':
                $extension = ".png";
                break;
            default:
                return null;
                break;
        }
        return $extension;
    }
    

    public static function TraerMayorId($ventas)
    {
        $maxId = $ventas[0]->id;
        foreach ($ventas as $vendido)
        {
            if($vendido->id > $maxId)
                $maxId = $vendido->id;
        }
        return $maxId;
    }


}
?>