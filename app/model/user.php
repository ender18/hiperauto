<?php
require_once "./app/model/model.php";
include_once "./app/model/dto/entidadDTO.php";
include_once "./app/model/dao/entidadDAO.php";
include_once "./app/model/dto/piezaDTO.php";
include_once "./app/model/dao/piezaDAO.php";


class UserModel extends Model {

    private $entidadDAO;

    public function __construct() {
        $this->entidadDAO = new EntidadDAO();
        $this->piezaDAO = new PiezaDAO();
    }

//Metodos sucurssal

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

//Metodos pieza

    function resgistrarPieza($form){
        $pieza = new piezaDTO($form['codigo'], $form['nombre']);
        return $this->piezaDAO->registrarPieza($pieza);
   }

   function mostrarPiezas(){
    return $this->piezaDAO->listarPiezas();
   }

   function buscarPieza($id){
    return $this->piezaDAO->buscarPieza($id);
   }

   function editarPiezaFormulario($form){
        $pieza = new PiezaDTO($form['codigo'], $form['nombre']);
        return $this->piezaDAO->editarPieza($pieza, $form['codigo']);
    }

    function eliminarPieza($id){
        return $this->piezaDAO->eliminarPieza($id);
    }
}

?>