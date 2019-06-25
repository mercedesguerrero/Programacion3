<?php

class Proveedor
{

    public $id;
    public $nombre;
    public $email;
    public $foto;

    function __construct($id, $nombre, $email, $foto)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->foto = $foto;
    }

    public function RetornarJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    //-------------------------------------- TRAE EXTENSION DE LA FOTO--------------------------------------------------------------
    public static function TraerExtensionFoto($files)
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
                return false;
                break;
        }
        return $extension;
    }

    //----------------------------------------------------------------------------------------------------------------------------------

    //--------------------------------------FUNCION GUARDAR PROVEEDOR-------------------------------------------------------------------
    public function Guardar($ruta)
    {
        echo "Entro EN GUARDAR";
        if(file_exists($ruta))
        {
           $archivo=fopen($ruta,"a");
           return fwrite($archivo,$this->RetornarJson().PHP_EOL);
        }

        $archivo=fopen($ruta,"w");
        return fwrite($archivo,$this->RetornarJson().PHP_EOL); 
    }//ends function Guardar (primero se debe crear un alumno)
    //------------------------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------CARGAR (GUARDAR) FOTO--------------------------------------------------------------------------------------
    public function CargarFoto($files)
    {
        if(isset($files))
        {
            if(!$extension = self::TraerExtensionFoto($files))
            {
                echo '<br/>Error: el formato de "foto" debe ser "jpg" o "png".';
                die;
            }
            $nombreDelArchivoFoto = $this->id."_".strtolower($this->nombre).$extension;

            $rutaFoto = "Fotos/".$nombreDelArchivoFoto;
            return move_uploaded_file($files["tmp_name"], $rutaFoto);
        }
        else
        {
            echo '<br/>Error: cargue una "foto".';
            die;
        }
    }



    //---------------------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------GUARDAAAR---------------------------------------------------------------------------------------
    public static function Cargar($ruta)
    {
        $retorno=false;
        if (file_exists($ruta))
        {
            $archivo=fopen($ruta,"r");
            $proveedores=array();
            while(!feof($archivo))
            {
            $linea=fgets($archivo);
            if($linea != "")
            {    
                    $stdObj=json_decode($linea);
                    $proveedor= new proveedor($stdObj->id,$stdObj->nombre,$stdObj->email,$stdObj->foto);
                    array_push($proveedores,$proveedor);
            }  

            }
            fclose($archivo);
            return $proveedores;

        }//carga Si la ruta existe
        return $retorno;
    }

    //-------------------------------------------------------------------------------------------------------------------------------------.

    //-------------------------------------------------TRAER PROVEEDOR POR ID----------------------------------------------------------------
    public static function TraerProveedorPorID($ruta,$id)
    {
            $proveedores= self::Cargar($ruta);
            if($proveedores==true)
            {
            //var_dump($proveedores);
                foreach ($proveedores as $proveedor)
                {
                    if($id == $proveedor->id)
                    return $proveedor;

                }

            }
            else{
                return false;
			}


    }
    //-------------------------------------------------------------------------------------------------------------------------------------------

    //-----------------------------------------------TRAER PROVEEDOR POR NOMBRE------------------------------------------------------------------
    public static function TraerProveedorPorNombre($ruta,$nombre)
    {
        $proveedores= self::Cargar($ruta);
        //var_dump($proveedores);
            foreach ($proveedores as $proveedor)
            {
                if($nombre == $proveedor->nombre)
                return $proveedor;

            }


            return false;
    }
    //---------------------------------------------------------------------------------------------------------------------------------------------

    //--------------------------------------------- METODO TO STRING  DE PROVEEDORES---------------------------------------------------------------

    public function ToString()
    {
        $texto = "";
        $texto .= "Id: ".$this->id."<br/>";
        $texto .= "Nombre: ".$this->nombre."<br/>";
        $texto .= "Email: ".$this->email."<br/>";
        $texto .= "Foto: ".$this->foto."<br/>";
        return $texto;
    }

    //----------------------------------------------------------------------------------------------------------------------------------------------

    //------------------------------------- CARGAR FOTOS BACKUP  -----------------------------------------------------------------------------------
    public function CargarFotoBackUp($directorioFotosBackUp, $directorioFotos, $rutaProveedor)
    {
        $proveedor = self::TraerProveedorPorId($rutaProveedor, $this->id);
        if(!$proveedor)
        {
            echo "<br/>No existe un proveedor con id ".$this->id.".";
            die;
        }
        $rutaFotoAntigua = $directorioFotos.$proveedor->foto;
        $extension = ".".array_reverse(explode(".", $proveedor->foto))[0];
        if(file_exists($rutaFotoAntigua))
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $rutaFotoBackUp = $directorioFotosBackUp.$this->id."_".date('Ymd').$extension;
            return rename($rutaFotoAntigua, $rutaFotoBackUp);
        }
        else
        {
            echo '<br/>Error: no existe la foto antigua.';
            die;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------
    public static function ModificarProveedorPorId($ruta, $id, $nuevoProveedor)
    {
        $proveedores = self::Cargar($ruta);
        
        if(!$proveedores || $proveedores == "NADA")
        {
            echo "<br/>No hay proveedores cargados.";
            die;
        }
        if(!self::TraerProveedorPorId($ruta, $id))
        {
            echo "<br/>No exite un proveedor con id ".$id.".";
            die;
        }
        foreach ($proveedores as $key => $prov)
        {
            if($prov->id == $nuevoProveedor->id)
            {
                $proveedores[$key] = $nuevoProveedor;
                break;
            }
        }
        return self::GuardarProveedores($ruta, $proveedores);
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------
    //-----------------------------------------GUARDAR PROVEEDOR DE MODIFICAR---------------------------------------------------------------------
    private static function GuardarProveedores($ruta, $proveedores)
    {
        $arch = fopen($ruta, "w");
        foreach ($proveedores as $proveedor)
        {
            if(!fwrite($arch, $proveedor->RetornarJson().PHP_EOL))
                return false;
        }
        return true;
    }


    //---------------------------------------------------------------------------------------------------------------------------------------------


    public static function MostrarTablaFotosBackUp($rutaProveedores, $rutaFotosBackUp)
    {
        $proveedores = self::Cargar($rutaProveedores);
        if(!$proveedores || $proveedores == "NADA")
            return "<br/>No hay proveedores cargados.";
        else
        {
            $directorios = scandir($rutaFotosBackUp);
            //Le saco los directorios "." y ".."
            $backUpInfo = array();
			
            foreach ($directorios as $key => $dir)
            {
                if($key >= 2)
                {
                    $stdObj = new stdClass();
                    $idAux = explode("_", $dir);
					$idAux2=$idAux[0];
                    $strAux = explode("_", $dir);
					$strAux2=$strAux[1];
                    $proveedor = self::TraerProveedorPorId($rutaProveedores, $idAux2);
                    if(!$proveedor)
                    {
                        echo "<br/>No existe un proveedor con id ".$idAux.".";
                        die;
                    }
                    $stdObj->nombre = $proveedor->nombre;
                    $stdObj->fecha = substr($strAux2, 6, 2)."/".substr($strAux2, 4, 2)."/".substr($strAux2, 0, 4);
                    array_push($backUpInfo, $stdObj);
                }
            }
            return self::FotosBackUpToTable($backUpInfo);
        }
    }

    //-----------------------------------------------------------------------------------------------------------------------------------------

    public static function FotosBackUpToTable($backUpInfo)
    {
        $texto = "<table border='1'>";
        $texto .= "<thead bgcolor='lightgrey'>";
        $texto .= "<tr>";
        $texto .= "<th>Nombre</th>";
        $texto .= "<th>Fecha</th>";
        $texto .= "</tr>";
        $texto .= "</thead>";
        $texto .= "<tbody>";
        foreach ($backUpInfo as $info)
        {
            $texto .= "<tr>";
            $texto .= "<td>".$info->nombre."</td>";
            $texto .= "<td>".$info->fecha."</td>";
            $texto .= "</tr>";
        }
        $texto .= "</tbody>";
        $texto .= "</table>";
        return $texto;
    }


}


?>