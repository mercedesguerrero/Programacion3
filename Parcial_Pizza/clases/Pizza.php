<?php

class Pizza
{
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantUnidades;

    function __construct($id, $sabor, $precio, $tipo, $cantUnidades)
    {
        $this->id = $id;
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantUnidades = $cantUnidades;
    }

    public function Guardar($path)
    {
        $pizzasList = self::Cargar($path);
        if($pizzasList != null)
        {
            $maxId = self::TraerMayorId($pizzasList);
            $this->id = $maxId + 1;
            if(!self::ExistePizzaEnLista($pizzasList, $this))
            {
                if(file_exists($path))
                {
                    $archivo = fopen($path, "a");
                    return fwrite($archivo, $this->DevolverJson().PHP_EOL);//PHP_EOL (string) El símbolo 'Fin De Línea' correcto de la plataforma en uso
                }
                $archivo = fopen($path, "w");
                return fwrite($archivo, $this->DevolverJson().PHP_EOL);
            }
        }
        else
        {
            if(file_exists($path))
            {
                $archivo = fopen($path, "a");
                return fwrite($archivo, $this->DevolverJson().PHP_EOL);
            }
            $archivo = fopen($path, "w");
            return fwrite($archivo, $this->DevolverJson().PHP_EOL);
        }
        return false;
    }

    public function DevolverJson()
    {
        //json_encode — Retorna la representación JSON del valor dado
        return json_encode($this, JSON_UNESCAPED_UNICODE);//Codificar caracteres Unicode multibyte literalmente
    }

    public static function GuardarTodo($pizzasList, $path)
    {
        if(file_exists($path))
        {
            foreach ($pizzasList as $key => $zapi)
            {
                if($key == 0)
                {
                    $archivo = fopen($path, "w");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, borra el contenido.
                    fwrite($archivo, json_encode($pizzasList[0]).PHP_EOL);
                    fclose($archivo);
                }
                else
                {
                    $archivo = fopen($path, "a");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, mantiene el contenido. El cursor comienza en el final del archivo.
                    fwrite($archivo, json_encode($pizzasList[$key]).PHP_EOL);
                    fclose($archivo);
                }
            }
            return true;
        }
        return false;
    }

    public static function Cargar($path)
    {
        if(file_exists($path))
        {
            $archivo = fopen($path, "r");//Abre un archivo para sólo lectura. El cursor comienza al principio del archivo.
            $pizzasList = array();
            while(!feof($archivo))
            {
                $renglon = fgets($archivo);
                if($renglon != "")
                {
                    $objeto = json_decode($renglon);//Decodifica un string de JSON(array asociativo)
                    if (isset($objeto)!=null) {
                        $pizza = new Pizza($objeto->id, $objeto->sabor, $objeto->precio, $objeto->tipo, $objeto->cantUnidades);
                        array_push($pizzasList, $pizza);
                    }
                    //isset -> Determina si una variable está definida y no es NULL
                }
            }
            fclose($archivo);

            if(count($pizzasList) > 0)//count — Cuenta todos los elementos de un array u objeto
                return $pizzasList;
        }
        return null;
    }

    private static function ExistePizzaEnLista($pizzasList, $pizza)
    {
        foreach ($pizzasList as $zapi)
        {
            if($zapi->id == $pizza->id)
                return true;
        }
        return false;
    }

    public static function ExistePizzaPorSaborYTipo($path, $sabor, $tipo)
    {
        $pizzasList = self::Cargar($path);
        
        if($pizzasList != null)
        {
            foreach ($pizzasList as $zapi)
            {
                if($sabor == $zapi->sabor &&
                    $tipo == $zapi->tipo){
                        return true;
                    }       
            }
        }
        return false;
    }

    public static function ExistePizzaPorSabor($path, $sabor)
    {
        $pizzasList = self::Cargar($path);

        if($pizzasList != null)
        {
            foreach ($pizzasList as $zapi)
            {
                if(strtolower($sabor) == strtolower($zapi->sabor)){
                    return true;
                }
            }
        }
        return false;
    }

    public static function TraerPizzaPorId($path, $id)
    {
        $pizzasList = self::Cargar($path);
        if($pizzasList != null)
        {
            foreach ($pizzasList as $zapi)
            {
                if($zapi->id == $id)
                    return $zapi;
            }
        }
        return null;
    }

    public static function DevuelvePizzaxSaboryTipo($path, $sabor, $tipo)
    {
        $pizzasList = self::Cargar($path);

        if($pizzasList != null)
        {
            foreach ($pizzasList as $zapi)
            {
                if($zapi->sabor == $sabor && $zapi->tipo == $tipo)
                    return $zapi;
            }
        }
        return null;
    }

    public static function TraerIdStock($path, $sabor, $tipo, $cantUnidades)
    {
        $pizzasList = self::Cargar($path);
        if($pizzasList != null)
        {
            foreach ($pizzasList as $zapi)
            {
                if($zapi->sabor == $sabor &&
                    $zapi->tipo == $tipo &&
                    $zapi->cantUnidades >= $cantUnidades)
                    return $zapi->id;
            }
        }
        return null;
    }
    
    public static function TraerMayorId($pizzasList)
    {
        $maxId = $pizzasList[0]->id;
        foreach ($pizzasList as $zapi)
        {
            if($zapi->id > $maxId)
                $maxId = $zapi->id;
        }
        return $maxId;
    }

    public function Vender($path, $cantUnidades)
    {
        $pizzasList = self::Cargar($path);
        if($pizzasList != null)
        {
            if(self::ExistePizzaEnLista($pizzasList, $this))
            {
                foreach ($pizzasList as $key => $zapi)
                {
                    if($zapi->id == $this->id)
                    {
                        $pizzasList[$key]->cantUnidades -= $cantUnidades;
                        break;
                    }
                }
                return self::GuardarTodo($pizzasList, $path);
            }
        }
        return false;
    }

    public function CargarImagen($files, $pathCarpetaImagenes)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                $nombreDelArchivoImagen = $this->tipo."_".strtolower($this->sabor).$extension;
                $pathCompletaImagen = $pathCarpetaImagenes.$nombreDelArchivoImagen;
                return move_uploaded_file($files["tmp_name"], $pathCompletaImagen);
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


    public static function ModificarStockYPrecio($path, $sabor, $tipo, $precio, $cantidad)
    {
        $pizzasList = self::Cargar($path);
        
        if(!$pizzasList || $pizzasList == "NADA")
        {
            echo "<br/>No hay pizzas cargadas.";
            die;
        }
        if(!self::ExistePizzaPorSaborYTipo($path, $sabor, $tipo))
        {
            echo "<br/>No hay pizza de ".$sabor." tipo ".$tipo.".";
        }
        else
        {
            foreach ($pizzasList as $key => $zapi)
            {
                if($zapi->sabor == $sabor && $zapi->tipo == $tipo)
                {
                    $zapi->precio= $precio;
                    $zapi->cantUnidades+= $cantidad;
                    break;
                }
            }
        }
        return self::GuardarTodo($pizzasList, $path);
    }

    public static function DevuelveArrayXsaborYtipo($path, $sabor, $tipo)
    {
        $pizzasList = self::Cargar($path);
        if($pizzasList != null)
        {
            $newpizzasList = array();
            foreach ($pizzasList as $zapi)
            {
                if($zapi->sabor == $sabor && $zapi->tipo == $tipo)
                    array_push($newpizzasList, $zapi);
            }
            if(count($newpizzasList) > 0)
                return $newpizzasList;
        }
        return null;
    }

    public function BorrarPizza($path, $pizzaABorrar)
    {
        $pizzasList = self::Cargar($path);

        if($pizzasList != null)
        {
            if(self::ExistePizzaEnLista($pizzasList, $pizzaABorrar))
            {
                foreach ($pizzasList as $key => $zapi)
                {
                    if($zapi->sabor == $pizzaABorrar->sabor && $zapi->tipo == $pizzaABorrar->tipo)
                    {
                        unset($pizzasList[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($pizzasList, $path);
            }
        }
        return false;
    }

    public function MoverImgABackUp($carpetaFotosBackup, $carpetaFotos, $path)
    {
        $pizza = self::DevuelvePizzaxSaboryTipo($path, $this->sabor, $this->tipo);
            
        if(!$pizza)
        {
            echo "<br/>No existe esa pizza.";
            die;
        }
        $extension = ".jpg";        
        $fotoPizza= $pizza->tipo . "_" . $pizza->sabor . $extension;
        $pathFotoOriginal = $carpetaFotos . $fotoPizza;
            
        if(file_exists($pathFotoOriginal))
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $pathFotoBackUp = $carpetaFotosBackup . "/" . date('Ymd') . "_" . $fotoPizza;
            return rename ($pathFotoOriginal, $pathFotoBackUp);
        }
        else
        {
            echo '<br/>Error! no existe la imagen.';
            die;
        }
    }


    public function IsEqual($otraPizza)
    {
        return  $this->sabor == $otraPizza->sabor && 
                $this->precio == $otraPizza->precio &&
                $this->tipo == $otraPizza->tipo &&
                $this->cantUnidades == $otraPizza->cantUnidades;
    }



}
?>