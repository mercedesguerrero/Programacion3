<?php
//require_once './clases/Pizza.php';

class Empleado
{
    public $id;
    public $email;
    public $alias;
    public $tipo;
    public $edad;

    function __construct($id, $email, $alias, $tipo, $edad)
    {
        $this->id = $id;
        $this->email = $email;
        $this->alias = $alias;
        $this->tipo = $tipo;
        $this->edad = $edad;
    }


    public function Guardar($ruta)
    {
        $empleados = self::Cargar($ruta);
        if($empleados != null)
        {
            $maxId = self::TraerMayorId($empleados);
            $this->id = $maxId + 1;
            if(!self::ExisteEmpleadoEnLista($empleados, $this))
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

    public static function GuardarTodo($empleados, $ruta)
    {
        if(file_exists($ruta))
        {
            foreach ($empleados as $key => $pi)
            {
                if($key == 0)
                {
                    $archivo = fopen($ruta, "w");
                    fwrite($archivo, json_encode($empleados[0]).PHP_EOL);
                    fclose($archivo);
                }
                else
                {
                    $archivo = fopen($ruta, "a");
                    fwrite($archivo, json_encode($empleados[$key]).PHP_EOL);
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
            $empleados = array();
            while(!feof($archivo))
            {
                $linea = fgets($archivo);
                if($linea != "")
                {
                    $objeto = json_decode($linea);
                    if(isset($objeto)!=null)
                    {
                        $empleado = new Empleado($objeto->id, $objeto->email, $objeto->alias, $objeto->tipo, $objeto->edad);
                        array_push($empleados, $empleado);
                    }
                    
                }
            }
            fclose($archivo);
            if(count($empleados) > 0)
                return $empleados;
        }
        return null;
    }

    private static function ExisteEmpleadoEnLista($empleados, $empleado)
    {
        foreach ($empleados as $emp)
        {
            if($emp->id == $empleado->id)
                return true;
        }
        return false;
    }

    public static function TraerEmpleadoPorId($ruta, $id)
    {
        $empleados = self::Cargar($ruta);
        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                if($emp->id == $id)
                    return $emp;
            }
        }
        return null;
    }

    
    public function CargarImagen($files, $rutaCarpetaEmpleados)
    {
        if(isset($files))
        {
            $extension = self::TraerExtensionImagen($files);
            if($extension != null)
            {
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $mail= explode("@", $this->email);
                $nombreDelArchivoImagen = $this->tipo."_".strtolower($this->alias)."_".$mail[0]."_".date('Ymd').$extension;
                $rutaCompletaImagen = $rutaCarpetaEmpleados.$nombreDelArchivoImagen;
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
    

    public static function TraerMayorId($empleados)
    {
        $maxId = $empleados[0]->id;
        foreach ($empleados as $emp)
        {
            if($emp->id > $maxId)
                $maxId = $emp->id;
        }
        return $maxId;
    }

    public function BorrarEmpleado($path, $empleadoABorrar)
    {
        $empleadosList = self::Cargar($path);

        if($empleadosList != null)
        {
            if(self::ExisteEmpleadoEnLista($empleadosList, $empleadoABorrar))
            {
                foreach ($empleadosList as $key => $emp)
                {
                    if($emp->tipo == $empleadoABorrar->tipo || $emp->email == $empleadoABorrar->email)
                    {
                        unset($empleadosList[$key]);
                        break;
                    }
                }
                return self::GuardarTodo($empleadosList, $path);
            }
        }
        return false;
    }

    public static function ImgEmpleadosEnTabla($path)
    {
        $imagenes = scandir($path);

        $retorno = "<table border = 3 bordercolor = red align = left>";
        $retorno .= "<tbody>";
        foreach ($imagenes as $img)
        {
            if(!file_exists($img))
            {
                $retorno .= "<tr>";
                $retorno .= "<td><img src='" . $path . $img . "' height='160' width='160' /></td>";
                $retorno .= "</tr>";
            }
        }
        $retorno .= "</tbody>"; 
        $retorno .= "</table>";
    
        return "<div> " . $retorno . "</div>";
    }

    public static function listarEmpleados($path)
    {
        $empleados = self::Cargar($path);

        $retorno = "";
        

        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                $retorno .= "<div align='left'>Id: " . $emp->id . 
                    " || Email: " . $emp->email . " || Alias: " . $emp->alias . 
                    " || Tipo: " . $emp->tipo . " || Edad: " . $emp->edad . "</div>";
                
            }
        }
        return $retorno;
    }

    public static function listarSoloNombres($path)
    {
        $empleados = self::Cargar($path);

        $retorno = "";
        

        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                $retorno .= "<div align='left'>Alias: " . $emp->alias . "</div>";
                
            }
        }
        return $retorno;
    }

    public static function ExisteEmpleadoPorEmail($path, $email)
    {
        $empleados = self::Cargar($path);

        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                if(strtolower($email) == strtolower($emp->email))
                {
                    return true;
                }
            }
        }
        return false;
    }

    public static function ModificarTipo($path, $email, $tipo)
    {
        $empleados = self::Cargar($path);
        
        if(!$empleados || $empleados == "NADA")
        {
            echo "<br/>No hay empleados cargados.";
            die;
        }
        if(!self::ExisteEmpleadoPorEmail($path, $email))
        {
            echo "<br/>No hay empleado con email: " . $email . ".";
        }
        else
        {
            foreach ($empleados as $key => $emp)
            {
                if($emp->email == $email)
                {
                    $emp->tipo= $tipo;
                    break;
                }
            }
        }
        return self::GuardarTodo($empleados, $path);
    }
    
    public static function DevuelveEmpleadoPorMailoTipo($path, $email, $tipo)
    {
        $empleados = self::Cargar($path);

        $retorno= array();

        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                if($emp->email == $email || $emp->tipo == $tipo)
                {
                    array_push($retorno, $emp);
                    //var_dump($retorno);
                    return $retorno;
                }
            }
        }
        return null;
    }

    public static function DevuelveEmpleadoPorMail($path, $email)
    {
        $empleados = self::Cargar($path);

        $retorno= array();

        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                if($emp->email == $email)
                {
                    array_push($retorno, $emp);
                    //var_dump($retorno);
                    return $retorno;
                }
            }
        }
        return null;
    }

    public static function DevuelveEmpleadoPorTipo($path, $tipo)
    {
        $empleados = self::Cargar($path);

        $retorno= array();

        if($empleados != null)
        {
            foreach ($empleados as $emp)
            {
                if($emp->tipo == $tipo)
                {
                    array_push($retorno, $emp);
                    //var_dump($retorno);
                    return $retorno;
                }
            }
        }
        return null;
    }

}
?>