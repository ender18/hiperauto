<?php
require_once "./app/model/model.php";
include_once "./app/model/dto/entidadDTO.php";
include_once "./app/model/dao/entidadDAO.php";

class UserModel extends Model {

    private $entidadDAO;

    public function __construct() {
        $this->entidadDAO = new EntidadDAO();
    }

    function registrarSucursal($form){
        $sucursal = new EntidadDTO($form['codigo'], $form['nombre'] , $form['direccion'], $form['ciudad'], null);
        return $this->entidadDAO->agregarSucursal($sucursal);
    }

    function mostrarSucursales(){
        return $this->entidadDAO->listarSucursales();
    } 

    function buscarSucursal($id){
        return $this->entidadDAO->buscarSucursal($id);
    }

    function editarSucursalFormulario($form){
        $sucursal = new EntidadDTO($form['codigo'], $form['nombre'] , $form['direccion'], $form['ciudad'], null);
        return $this->entidadDAO->editarSucursal($sucursal, $form['codigoh']);
    }

    function eliminarSucursal($id){
        return $this->entidadDAO->eliminarSucursal($id);
    }

}

?>