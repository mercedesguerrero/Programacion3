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
/*
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
    */
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

    public function IsEqual($otraPizza)
    {
        return  $this->sabor == $otraPizza->sabor && 
                $this->precio == $otraPizza->precio &&
                $this->tipo == $otraPizza->tipo &&
                $this->cantUnidades == $otraPizza->cantUnidades;
    }


}
?>