<?php

require_once "./app/model/model.php";
include_once "./app/model/dto/almacenDTO.php";

class AlmacenDAO extends Model{
    
    public function agregarAlAlmacen($sucursalDTO, $piezaDTO, $stock, $stock_min) {
        if($this->buscarAlmacen($sucursalDTO->getCod_entidad(), $piezaDTO->getCod_pieza())){
        	return "ERROR LA PIEZA YA ESTA ASIGNADA AL ALMACEN!";
        }
        $insert = "INSERT INTO `almacen` (`cod_sucursal`, `cod_pieza`, `stock`, `stock_min`) VALUES ('".$sucursalDTO->getCod_sucursal()."','".$piezaDTO->getCod_pieza()."','".$stock."', '".$stock_min."')";
        $this->connect();
        $this->query($insert);
        $this->terminate();
        return "PIEZA ASIGNADA AL ALMACEN!";
    }
    
    public function modificar(){
        
    }

    public function verAlmacen($sucursalDTO){
    	$consulta = "SELECT * FROM almacen WHERE cod_sucursal = sucursalDTO->getCod_entidad()";
    	$this->connect();
    	$array = array();
    	$query = $this->query($consulta);
    	$this->terminate();

    	while ($row = mysqli_fetch_array($query)) {
    		$almacen = new AlmacenDTO($row['cod_sucursal'], $row['cod_pieza'],$row['stock'], $row['stock_min']);
    		array_unshift($array, $almacen);
    	}

    	return $array;
    }

    private function buscarAlmacen($sucusal,$pieza){
        $exito = false;
        $queryExist = "SELECT count(*) as conteo from almacen where (cod_sucusal ="$sucusal" and cod_pieza = "$pieza")";
        $this->connect();
        $consulta= $this->query($queryExist);
        $extraido= mysqli_fetch_array($consulta);
        if( $extraido['conteo'] != 0){
            $this->terminate();
            return true;
        }

        $this->terminate();
        return $exito;
    }
    
}

?>