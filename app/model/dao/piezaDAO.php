<?php

include_once "./app/model/model.php";
require_once "./app/model/dto/piezaDTO.php";

class PiezaDAO extends Model{
    
    public function registrarPieza($piezaDTO){

    	if($this->buscarPieza($piezaDTO->getCod_entidad())){
            return "ERROR AL REGISTRAR! LA PIEZA YA EXISTE";
        }

        $insert = "INSERT INTO `pieza` (`cod_pieza`, `nombre`) VALUES ('".$piezaDTO->getCod_Pieza()."','".$piezaDTO->getNombre()."')";
        $this->connect();
        $this->query($insert);
        $this->terminate();
        return "PIEZA REGISTRADA EXITOSAMENTE!";
    }
    
    public function listarPiezas(){
        $consulta = "SELECT * FROM pieza";
        $this->connect();
        $array = array();
        $query = $this->query($consulta);
        $this->terminate();

        while($row = mysqli_fetch_array($query)){
            $pieza = new EntidadDTO($row["cod_pieza"], $row["nombre"]);
            array_unshift($array,$pieza);
        }

        return $array;
    }
    
    public function eliminarPieza($cod_pieza){
        $consulta = "DELETE FROM pieza WHERE cod_pieza =".$cod_pieza"";
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
        return "SE HA ELIMINADO CORRECTAMENTE";
    }
    
    public function modificarPieza($piezaDTO, $cod_pieza){
        
    }

    public function busquedaFiltrada($piezaDTO){

    }

    private function componerConsulta($piezaDTO){

    }

    public function buscarPieza($codigo){
        $exito = false;
        $queryExist = "SELECT count(*) as conteo from pieza where (cod_pieza =".$codigo")";
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