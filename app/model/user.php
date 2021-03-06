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
include_once "./app/model/util/classUtil.php";

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


//Sucursal

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
        return $this->entidadDAO->busquedaFiltrada($sucursal);
    }

    function mostrarEnditdades(){
        return $this->entidadDAO->mostrarEntidades();
    }

    //Pieza

    function editarPiezaFormulario($form){
        $pieza = new PiezaDTO($form['codigo'], $form['nombre']);
        return $this->piezaDAO->editarPieza($pieza, $form['codigoh']);
    }

    function verAlmacen($codigo){
        return $this->almacenDAO->verAlmacen($codigo);
    }

    function registrarPieza($form){
       $pieza = new PiezaDTO($form['codigo'], $form['nombre']);
       return $this->piezaDAO->agregarPieza($pieza);
    }

<<<<<<< HEAD

=======
>>>>>>> origin/master
    function eliminarPiezaPedido($get){
        return $this->piezaXPedidoDAO->eliminarPiezaPedido($get['cod_pedido'], $get['cod_pieza']);
    }

    function eliminarPieza($id){
        return $this->piezaDAO->eliminarPieza($id);
    }

    function buscarPieza($id){
        return $this->piezaDAO->obtenerPieza($id);
    }

    function listarPieza(){
        return $this->piezaDAO->listarPiezas();
    }

    function busquedaFiltradaPieza($form){
        return $this->pedidoDAO->busquedaFiltrada(new PiezaDTO($form['codigo'], $form['nombre']));
    }

    // pedido
    function hacerPedido($emisor, $receptor, $fecha_entrega,  $tipo){
        return $this->pedidoDAO->crearPedido($emisor, $receptor, $fecha_entrega, $tipo);
    }

    function listarPiezasPedido($id_pedido){
        return $this->piezaXPedidoDAO->listarPiezasPedido($id_pedido);
<<<<<<< HEAD
    }   
=======
    }

    public function buscarPedido($codPedido){
        return $this->pedidoDAO->buscarPedido($codPedido);
        
    }

>>>>>>> origin/master

    function agregarPiezaPedido($cod_receptor, $codPedido, $codPieza, $cantidad){
        $hayDisponibles= $this->almacenDAO->hayDisponibles($cod_receptor, $codPieza, $cantidad);
        if($hayDisponibles){
            $this->piezaXPedidoDAO->agregarPiezaPedida($codPedido, $codPieza, $cantidad);
            return true;
        }else{
            return false;
        }
    }

<<<<<<< HEAD
    function listarPedidos(){
=======
    


    function mostrarPedidos(){
>>>>>>> origin/master
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

<<<<<<< HEAD
    function busquedaFiltradaPedido($nom_emisor, $nom_receptor, $cod_pedido){
        return $this->pedidoDAO->busquedaFiltrada($nom_emisor, $nom_receptor, $cod_pedido);
    }

=======
    
>>>>>>> origin/master
}

?>