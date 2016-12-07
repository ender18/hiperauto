<?php
require_once "./app/model/model.php";
include_once "./app/model/dao/entidadDAO.php";
include_once "./app/model/dto/entidadDTO.php";
include_once "./app/model/dao/almacenDAO.php";
include_once "./app/model/dto/almacenDTO.php";
include_once "./app/model/dao/pedidoDAO.php";
include_once "./app/model/dto/pedidoDTO.php";
include_once "./app/model/dao/piezaDAO.php";
include_once "./app/model/dto/piezaDTO.php";
include_once "./app/model/dao/piezaXpedidoDAO.php";
include_once "./app/model/dto/piezaXpedidoDTO.php";
include_once "./app/model/util/classUtil.php";]

class UserModel extends Model {

    private $entidadDAO;
    private $piezaDAO;
    private $almacenDAO;
    private $pedidoDAO;
    private $piezaXPedidoDAO;

    public function __construct() {
        $this->entidadDAO = new EntidadDAO();
        $this->piezaDAO = new PiezaDAO();
        $this->almacenDAO = new AlmacenDAO();
        $this->pedidoDAO = new PedidoDAO();
        $this->piezaXPedidoDAO = new PiezaXPedidoDAO();
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

    function busquedaFiltradaEntidad($form){
        $sucursal = new EntidadDTO($form['codigo'], $form['nombre'] , $form['direccion'], $form['ciudad'], null);
        return $this->entidadDAO->agregarSucursal($sucursal);
    }

    function mostrarEnditdades(){
        return $this->entidadDAO->mostrarEntidades();

    }

    function registrarPieza($form){
       $pieza = new PiezaDTO($form['codigo'], $form['nombre']);
       echo($form['codigo'].$form['nombre']);
       return $this->PiezaDAO->registrarPieza($pieza);
    }

    function eliminarPieza($id){
        return $this->piezaDAO->eliminarPieza($id);
    }

    function editarPieza($form){
        
    }

    function listarPieza(){
        return $this->piezaDAO->listarPiezas();
    }

    function busquedaFiltradaPieza($form){
        
    }

    function hacerPedidoSucursal($emisor, $receptor, $tipo, $fecha_entrega){
        return $this->pedidoDAO->crearPedido($emisor->getCod_entidad(), $receptor->getCod_entidad, $tipo, $fecha_entrega);
    }

    function hacerPedidoConcesionario($emisor, $tipo, $fecha_entrega){
        return $this->pedidoDAO->crearPedido($emisor->getCod_entidad(), $emisor->getCod_sucursal(), $tipo, $fecha_entrega);
    }

    function agregarPiezaPedido($codPedido, $codPieza, $cantidad){
        $pedido = $this->pedidoDAO->buscarPedido($codPedido);
        $pieza = $this->PiezaDAO->obtenerPieza($codPedido);
        if(!$this->piezaXPedidoDAO->buscarPiezaPedido($codPieza, $codPedido)){
            if($this->almacenDAO->enviarPiezas($pedido->getReceptor(), $pieza->getCod_pieza(), $cantidad)){
                return $this->piezaXPedidoDAO->registrarPiezaPedido($pedido, $pieza, $cantidad);
            }
        }
        return "OCURRIO UN ERROR AL AGREGAR LA PIEZA AL PEDIDO";
    }

    function listarPedidos(){
        return $this->pedidoDAO->listarPedidos();
    }

    function eliminarPedido($cod_pedido){
        return $this->pedidoDAO->eliminarPedido($cod_pedido);
    }

    function editarPedido($form){

    }

    function listarPiezaPedido($cod_pedido){
        $classUtil = $this->piezaXPedidoDAO->listarPiezaPedido($cod_pedido);

        foreach ($classUtil as $pieza){
            $piezaDTO = $this->obtenerPieza($pieza->getCod_pieza());
            $pieza->setAtribute1($piezaDTO->getNombre());
        }

        return $classUtil;
    }

}

?>