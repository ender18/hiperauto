<?php

include_once "./app/model/model.php";
require_once "./app/model/dto/PiezaXPedidoDTO.php";
include_once "./app/model/util/classUtil.php";]

class PiezaXPedidoDAO extends Model{

    private $arrayCantidades;
    
    public function registrarPiezaPedido($pedidoDTO, $PiezaDTO, $cantidad){
    	if($this->buscarPiezaPedido($PiezaDTO->getCod_pieza(), $pedidoDTO->getCod_pedido())){
    		return "ERROR AL AGREGAR LA PIEZA, ESA PIEZA YA ESTA REGISTRADA EN EL PEDIDO!";
    	}

    	$consulta = "INSERT INTO `piezaXpedido` (`cod_pieza`,`cod_pedido`,`cantidad`) values ('$PiezaDTO->getCod_pieza()','$pedidoDTO->getCod_pedido()', '$cantidad')";
    	$this->connect();
    	$this->query($consulta);
    	$this->terminate();
    	return "PIEZA AGREGADA AL PEDIDO!";
    }

    public function listarPedidos(){
    	$consulta = "SELECT * FROM piezaXpedido";
    	$this->connect();
    	$array = array();
    	$query = $this->query($consulta);
    	$this->terminate();

    	while ($row = mysqli_fetch_array($query)) {
    		$piezaXpedido = new PiezaXPedidoDTO($row['cod_pieza'], $row['cod_pedido'], $row['cantidad']);
    		array_unshift($array, $piezaXpedido);
    	}

    	return $array;
    }

    public function modificarPiezaPedido(){

    }

    public function eliminarPiezaPedido(){
    	
    }

    public function listarPiezasPedido($cod_pedido){
        $consulta = "SELECT cod_pieza, cantidad FROM piezaXpedido WHERE cod_pedido = $cod_pedido"
        $this->connect();
        $array = array();
        $query = $this->query($consulta);
        $this->terminate();

        while ($row = mysqli_fetch_array($query)) {
            $classUtil = new ClassUtil("", $row['cod_pieza'], $row['cantidad'], "", "", "");
            array_unshift($array, $classUtil);
        }
        return $array;
    }

    public function buscarPiezaPedido($codPieza, $cod_pedido){
    	$exito = false;
        $queryExist = "SELECT count(*) as conteo from piezaXpedido where (cod_pedido = $cod_pedido and cod_pieza = $cod_pieza)";
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