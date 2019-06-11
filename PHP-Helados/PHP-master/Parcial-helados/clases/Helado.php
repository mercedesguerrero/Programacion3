<?php
class Helado
{
public $id;
public $sabor;
public $precio;
public $tipo;
public $cantidadKg;

function __construct($id, $sabor, $precio, $tipo, $cantidadKg)
{
    $this->id = $id;
    $this->sabor = $sabor;
    $this->precio = $precio;
    $this->tipo = $tipo;
    $this->cantidadKg = $cantidadKg;
}

public function Guardar($path)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        $maxId = self::TraerMayorId($heladosList);
        $this->id = $maxId + 1;
        if(!self::ExisteHeladoEnLista($heladosList, $this))
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

public static function GuardarTodo($heladosList, $path)
{
    if(file_exists($path))
    {
        foreach ($heladosList as $key => $icecream)
        {
            if($key == 0)
            {
                $archivo = fopen($path, "w");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, borra el contenido.
                fwrite($archivo, json_encode($heladosList[0]).PHP_EOL);
                fclose($archivo);
            }
            else
            {
                $archivo = fopen($path, "a");//Abre un archivo para sólo escritura. Si no existe, crea uno nuevo. Si existe, mantiene el contenido. El cursor comienza en el final del archivo.
                fwrite($archivo, json_encode($heladosList[$key]).PHP_EOL);
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
        $heladosList = array();
        while(!feof($archivo))
        {
            $renglon = fgets($archivo);
            if($renglon != "")
            {
                $objeto = json_decode($renglon);//Decodifica un string de JSON(array asociativo)
                if (isset($objeto)!=null) {
                    $helado = new Helado($objeto->id, $objeto->sabor, $objeto->precio, $objeto->tipo, $objeto->cantidadKg);
                    array_push($heladosList, $helado);
                }
                //isset -> Determina si una variable está definida y no es NULL
            }
        }
        fclose($archivo);

        if(count($heladosList) > 0)//count — Cuenta todos los elementos de un array u objeto
            return $heladosList;
    }
    return null;
}

private static function ExisteHeladoEnLista($heladosList, $helado)
{
    foreach ($heladosList as $icecream)
    {
        if($icecream->id == $helado->id)
            return true;
    }
    return false;
}

public static function ExisteHeladoPorSaborYTipo($path, $sabor, $tipo)
{
    $heladosList = self::Cargar($path);
    
    if($heladosList != null)
    {
        foreach ($heladosList as $icecream)
        {
            if($sabor == $icecream->sabor &&
                $tipo == $icecream->tipo){
                    return true;
                }       
        }
    }
    return false;
}

public static function ExisteHeladoPorSabor($path, $sabor)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        foreach ($heladosList as $icecream)
        {
            if(strtolower($sabor) == strtolower($icecream->sabor)){
                return true;
            }
        }
    }
    return false;
}

public static function heladosATabla($heladosList, $pathCarpetaImagenes)
{
    $texto = "<div align='center'>";
    $texto .= "<table  width=\"768\" border=\"1px\">";
    $texto .= "<thead bgcolor='#ff8080'>";
    $texto .= "<tr height=\"40\">";
    $texto .= "<th width=\"150\" align=\"center\" valign=\"center\">Imagen</th>";
    $texto .= "<th width=\"53\" align=\"center\" valign=\"center\">Sabor</th>";
    $texto .= "<th width=\"53\" align=\"center\" valign=\"center\">Precio</th>";
    $texto .= "<th width=\"53\" align=\"center\" valign=\"center\">Tipo</th>";
    $texto .= "<th width=\"53\" align=\"center\" valign=\"center\">Cantidad</th>";
    $texto .= "</tr>";
    $texto .= "</thead>";
    $texto .= "<tbody>";
    foreach ($heladosList as $helado)
    {
        $texto .= "<tr>";
        $texto .= "<td width=\"150\" align=\"center\" valign=\"center\"><img src='".$pathCarpetaImagenes.$helado->id."_".$helado->sabor.".png' height='75' width='75' /></td>";
        $texto .= "<td width=\"53\" align=\"center\" valign=\"center\">".$helado->sabor."</td>";
        $texto .= "<td width=\"53\" align=\"center\" valign=\"center\">".$helado->precio."</td>";
        $texto .= "<td width=\"53\" align=\"center\" valign=\"center\">".$helado->tipo."</td>";
        $texto .= "<td width=\"53\" align=\"center\" valign=\"center\">".$helado->cantidadKg."</td>";
        $texto .= "</tr>";
    }
    $texto .= "</tbody>";
    $texto .= "</table>";
    $texto .= "</div>";
    return $texto;
}

//manejo de imagenes

public function CargarImagen($files, $rutaCarpetaImagenes)
{
    if(isset($files))
    {
        $extension = self::TraerExtensionImagen($files);
        $marca= $rutaCarpetaImagenes."recursosGraf/marcaDeAguaHelado.png";

        if($extension != null)
        {   
            $nombreDelArchivoImagen = $this->id."_".strtolower($this->sabor).$extension;
            $rutaCompletaImagen = $rutaCarpetaImagenes.$nombreDelArchivoImagen;
            $resulta= move_uploaded_file($files["tmp_name"], $rutaCompletaImagen);
            $archivo=self::agregarMarcaAgua($rutaCompletaImagen, $marca);
            return $resulta;
        }
    }
    return false;
}

public function agregarMarcaAgua($archivo, $marca)
{
    $im = imagecreatefrompng($archivo);
    $estampa = imagecreatefrompng($marca);
    
    $margen_dcho = 10;
    $margen_inf = 10;
    $sx = imagesx($estampa);
    $sy = imagesy($estampa);
    imagecopy($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa));
    imagepng($im, $archivo);
}

/*
public function CargarImagen($files, $pathCarpetaImagenes)
{
    if(isset($files))
    {
        $extension = self::TraerExtensionImagen($files);
        $marca= $pathCarpetaImagenes."recursosGraf/marcaDeAguaHelado.png";

        if($extension != null)
        {
            $nombreDelArchivoImagen = $this->id."_".strtolower($this->sabor).$extension;
            $pathCompletaImagen = $pathCarpetaImagenes.$nombreDelArchivoImagen;
            $retorno= move_uploaded_file($files["tmp_name"], $pathCompletaImagen);
            $archivo= self::agregarMarcaAgua($pathCarpetaImagenes, $marca);
            return $retorno;
        }
    }
    return false;
}

public function agregarMarcaAgua($filename, $url)
{
    $img= imagecreatefrompng($filename);
    $estampa = imagecreatefrompng($url);

    echo "<h1>marca de agua hecha OK</h1>";
    // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
    $margen_dcho = 10;
    $margen_inf = 10;

    $sx = imagesx($estampa);
    $sy = imagesy($estampa);
    // Copiar la imagen de la estampa sobre nuestra foto usando los índices de márgen y el
    // ancho de la foto para calcular la posición de la estampa.
    imagecopy($img, $estampa, imagesx($img) - $sx - $margen_dcho, imagesy($img) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa));
    // Imprimir y liberar memoria
    //header('Content-type: image/png');
    imagepng($img, $filename);

}
*/
//revisar este código

public function MoverImagenABackUp($directorioFotosBackUp, $directorioFotos, $pathheladosList)
{
    $helado = self::TraerHeladoPorId($pathheladosList, $this->id);
        if(!$helado)
        {
            echo "<br/>No existe una helado con ese id ".$this->id.".";
            die;
        }
        $extension = ".png";		
		$fotoAntigua= $helado->id . "_" . $helado->sabor . $extension;
        $pathFotoAnterior = $directorioFotos . $fotoAntigua;
		
        if(file_exists($pathFotoAnterior))
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $pathFotoBackUp = $directorioFotosBackUp .date('Ymd') . "_" .$fotoAntigua;
            return rename ($pathFotoAnterior, $pathFotoBackUp);
        }
        else
        {
            echo '<br/>Error: no existe la foto anterior.';
            die;
        }
}


//fin de manejo de imagenes

public function Vender($path, $cantidadKg)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        if(self::ExisteHeladoEnLista($heladosList, $this))
        {
            foreach ($heladosList as $key => $icecream)
            {
                if($icecream->id == $this->id)
                {
                    $heladosList[$key]->cantidadKg -= $cantidadKg;
                    break;
                }
            }
            return self::GuardarTodo($heladosList, $path);
        }
    }
    return false;
}

public function BorrarHelado($path)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        if(self::ExisteHeladoEnLista($heladosList, $this))
        {
            foreach ($heladosList as $key => $icecream)
            {
                if($icecream->id == $this->id)
                {
                    unset($heladosList[$key]);
                    break;
                }
            }
            return self::GuardarTodo($heladosList, $path);
        }
    }
    return false;
}

public static function ModificarHeladoPorId($path, $id, $nuevoHelado)
{
    $heladosList = self::Cargar($path);
    
    if(!$heladosList || $heladosList == "NADA")
    {
        echo "<br/>No hay heladosList cargadas.";
        die;
    }
    if(!self::TraerHeladoPorId($path, $id))
    {
        echo "<br/>No existe un helado con id ".$id.".";
        die;
    }
    foreach ($heladosList as $key => $helado)
    {
        if($helado->id == $nuevoHelado->id)
        {
            $heladosList[$key] = $nuevoHelado;
            break;
        }
    }
    return self::GuardarTodo($heladosList, $path);
}

//Funciones de  TRAER
public static function TraerHeladoPorsabor($path, $sabor)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        $misheladosList = array();
        foreach ($heladosList as $icecream)
        {
            if($icecream->sabor == $sabor)
                array_push($misheladosList, $icecream);
        }
        if(count($misheladosList) > 0)
            return $misheladosList;
    }
    return null;
}

public static function TraerHeladoPorTipo($path, $tipo)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        $misheladosList = array();
        foreach ($heladosList as $icecream)
        {
            if($icecream->tipo == $tipo)
                array_push($misheladosList, $icecream);
        }
        if(count($misheladosList) > 0)
            return $misheladosList;
    }
    return null;
}

public static function TraerHeladoPorId($path, $id)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        foreach ($heladosList as $icecream)
        {
            if($icecream->id == $id)
                return $icecream;
        }
    }
    return null;
}

public static function TraerIdStock($path, $sabor, $tipo, $cantidadKg)
{
    $heladosList = self::Cargar($path);
    if($heladosList != null)
    {
        foreach ($heladosList as $helado)
        {
            if($helado->sabor == $sabor &&
                $helado->tipo == $tipo &&
                $helado->cantidadKg >= $cantidadKg)
                return $helado->id;
        }
    }
    return null;
}

public static function TraerMayorId($heladosList)
{
    $maxId = $heladosList[0]->id;
    foreach ($heladosList as $icecream)
    {
        if($icecream->id > $maxId)
            $maxId = $icecream->id;
    }
    return $maxId;
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

public function IsEqual($otroHelado)
{
    return  $this->sabor == $otroHelado->sabor && 
            $this->precio == $otroHelado->precio &&
            $this->tipo == $otroHelado->tipo &&
            $this->cantidad == $otroHelado->cantidadKg;
}


}
?>