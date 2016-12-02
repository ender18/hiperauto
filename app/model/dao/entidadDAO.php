<?php

require_once "./app/model/model.php";
include_once "./app/model/dto/entidadDTO.php";

class EntidadDAO extends Model{

    private $entidadDTO;

    public function __construct(){
        
    }

    public function agregarSucursal($EntidadDTO){

        if($this->buscarEntidad($EntidadDTO->getCond_entidad())){
            return "la entidad ya existe!.";
        }

        $insert = "INSERT INTO `Entidad` (`cod_entidad`, `nombre`, `direccion`, `ciudad`, `cod_sucursal`) VALUES ('$EntidadDTO->getCod_entidad()', '$EntidadDTO->getNombre()', '$EntidadDTO->getDireccion()', '$EntidadDTO->getCiudad()', '$EntidadDTO->getCod_sucursal()')";
        $this->connect();
        $this->query($insert);
        $this->terminate();
        return "entidad registrada exitosamente!."
    }
        
    
    public function eliminarSucursal($idSucursal){
        
    }
    
    public function listarSucursales(){
        $consulta = "SELECT * FROM Entidad WHERE cod_sucursal is null";
        $array = array();
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();

        while($row = mysqli_fetch_array($query)){
            $sucursal = new EntidadDTO($row["cod_entidad"], $row["nombre"], $row["direccion"], $row["ciudad"], 0);
            array_unshift($array,$sucursal);
        }
        return $array;
    }

    public function listarConcesionarios(){
        $consulta = "SELECT * FROM Entidad WHERE cod_sucursal is not null";
        $array = array();
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();

        while($row = mysqli_fetch_array($query)){
            $concesionario = new EntidadDTO($row["cod_entidad"], $row["nombre"], $row["direccion"], $row["ciudad"], 
                $row["cod_sucursal"]);
            array_unshift($array,$concesionario);
        }
        return $array;
    }


    
    public function modificarSucursal($EntidadDTO){
        
    }
    
    public function listarSucursalesExcepto($cod_sucursal){
        $consulta = "SELECT * FROM Entidad WHERE cod_entidad <> $cod_sucursal is null";
        $array = array();
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();

        while($row = mysqli_fetch_array($query)){
            $sucursal = new EntidadDTO();
        }
    }

    public function buscarEntidad($EntidadDTO){
        $exito = false;
        $queryExist = "SELECT count(*) from Entidad where cod_entidad = $EntidadDTO->getCod_entidad";
        $this->connect();

        if($this->query($queryExist) != 0){
            $this->terminate();
            $exito = true;
        }

        return $exito;
    }
}

?>