<?php

require_once "./app/model/model.php";
include_once "./app/model/dto/entidadDTO.php";

class EntidadDAO extends Model{

    private $entidadDTO;

    public function __construct(){
        
    }

    public function agregarSucursal($EntidadDTO){
        if($this->buscarEntidad($EntidadDTO->getCod_entidad())){
            return "ERROR AL REGISTRAR! LA ENTIDAD YA EXISTE";
        }
        $insert = "INSERT INTO `entidad` (`codigo`, `nombre`, `direccion`, `ciudad`, `cod_sucursal`) VALUES ('".$EntidadDTO->getCod_entidad()."','".$EntidadDTO->getNombre()."','".$EntidadDTO->getDireccion()."', '".$EntidadDTO->getCiudad()."', '".$EntidadDTO->getCod_sucursal()."')";
        $this->connect();
        $this->query($insert);
        $this->terminate();
        return "ENTIDAD REGISTRADA EXITOSAMENTE";
    }
        
    
    public function eliminarSucursal($idSucursal){
        $consulta = "DELETE FROM Entidad WHERE codigo = $idSucursal";
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
        return $query;
    }

    public function buscarSucursal($id){
        $consulta = "SELECT * FROM entidad where (codigo=".$id.")";
        $array = array();
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
        $row =mysqli_fetch_array($query);
        array_unshift($array, new EntidadDTO($row["codigo"], $row["nombre"], $row["direccion"], $row["ciudad"], 0));
        return $array;
    }
    
    public function listarSucursales(){
        $consulta = "SELECT * FROM entidad WHERE (cod_sucursal=0)";
        $array = array();
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
        while($row = mysqli_fetch_array($query)){
            $sucursal = new EntidadDTO($row["codigo"], $row["nombre"], $row["direccion"], $row["ciudad"], 0);
            array_unshift($array,$sucursal);
        }
        return $array;
    }

    public function editarSucursal($form, $id){
        if($this->buscarEntidad($id)){
            return "ERROR AL EDITAR! EL CODIGO DE ESA SUCURSAL YA EXISTE";
        }
        $insert = "UPDATE entidad SET codigo='".$EntidadDTO->getCod_entidad()."', nombre='".$EntidadDTO->getNombre()."','".
        $EntidadDTO->getDireccion()."', '".$EntidadDTO->getCiudad()."', '".$EntidadDTO->getCod_sucursal()
        $this->connect();
        $this->query($insert);
        $this->terminate();
        return "LA SUCURSAL FUE EDITADA EXITOSAMENTE";
    }


    public function listarConcesionarios(){
        $consulta = "SELECT * FROM entidad WHERE cod_sucursal is not null";
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
        $consulta = "SELECT * FROM entidad WHERE cod_entidad <> $cod_sucursal is null";
        $array = array();
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();

        while($row = mysqli_fetch_array($query)){
             $sucursal = new EntidadDTO($row["codigo"], $row["nombre"], $row["direccion"], $row["ciudad"], 0);
            array_unshift($array,$sucursal);
        }
        return $array;
    }


    public function buscarEntidad($codigo){
        $exito = false;
        $queryExist = "SELECT count(*) as conteo from entidad where (codigo =".$codigo.")";
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