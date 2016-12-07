<?php

include_once "./app/model/model.php";
require_once "./app/model/dto/pedidoDTO.php";

class PedidoDAO extends Model{

	public function crearPedido($emisorDTO, $receptoDTO, $tipo, $fecha_entrega){
		$array = getdate();
        $fecha = $array['mday']."-".$array['mon']."-".$array['year'];

		$consulta = "INSERT INTO `pedido` (`cod_emisor`,`cod_receptor`,`fecha_pedido`,`fecha_entrega`,`tipo`,`estado`) values ('$emisorDTO-getCod_entidad()', '$receptorDTO->getCod_entidad()', STR_TO_DATE( '$fecha', '%d-%m-%Y' ), '$fecha_entrega', '$tipo', 'Pendiente')";
		$this->connect();
		$this->query($consulta);
		$this->terminate();
		return $this->obtenerCodigoPedido($emisorDTO, $receptoDTO, $fecha);
	}
    
    public function listarPedidos(){
        $consulta = "SELECT * FROM pedidos";
        $this->connect();
        $array = array();
        $query = $this->query($consulta);
        $this->terminate();

        while($row = mysqli_fetch_array($query)){
        	$pedido = new PedidoDTO($query['cod_pedido'], $query['cod_emisor'], $query['cod_receptor'], $query['fecha_pedido'], $query['fecha_entrega'], $query['estado'], $query['tipo']);
        	array_unshift($array, $pedido);
        }
        return $array;
    }
    
    public function eliminarPedido($codigo){
        $consulta = "DELETE FROM pedido WHERE cod_pedido = $codigo";
        $this->connect();
        $this->query($query);
        $this->terminate();
        return "PEDIDO ELIMINADO EXITOSAMENTE!";
    }
    
    public function modificarPedido($PedidoDTO, $codigo){
        if($codigo != $PedidoDTO->getCod_pedido()){
            if($this->buscarPedido($PedidoDTO->getCod_pedido()) <> null){
                 return "ERROR AL EDITAR! EL NUEVO CODIGO DE ESA PEDIDO YA ESTA ASOCIADO CON OTRO, INTENTELO DE NUEVO";
            }
        }

        $insert = "UPDATE pedido SET cod_pedido ='".$PedidoDTO->getCod_pedido()."', cod_emisor = '".$PedidoDTO->getCod_emisor()."', cod_receptor = '".$PedidoDTO->getCod_receptor()."', fecha_pedido = '".$PedidoDTO->getFecha_pedido()."', fecha_entrega = '".$PedidoDTO->getFecha_entrega()."', estado = '".$PedidoDTO->getEstado()."', tipo = '".$PedidoDTO->getTipo()."' WHERE cod_pedido =".$cod_pedido."";
        $this->connect();
        $this->query($insert);
        $this->terminate();
        return "EL PEDIDO FUE EDITADO EXITOSAMENTE!";
    }

    public function obtenerCodigoPedido($emisorDTO, $receptorDTO, $fecha){
    	$consulta = "SELECT cod_pedido FROM pedido WHERE cod_emisor = $emisorDTO->getCod_entidad() and cod_receptor = $receptorDTO->getCod_entidad() and fecha_pedido = $fecha";
    	$this->connect();
    	$query = $this->query($consulta);
    	$this->terminate();
    	return $query['cod_pedido'];
    }

    public function buscarPedido($codigo){
    	$consulta = "SELECT * FROM pedido WHERE cod_pedido = $codigo";
    	$this->connect();
    	$query = mysqli_fetch_array($this->query($consulta));
    	$this->terminate();
    	return new PedidoDTO($query['cod_pedido'], $query['cod_emisor'], $query['cod_receptor'], $query['fecha_pedido'], $query['fecha_entrega'], $query['estado'], $query['tipo']);
    }
    
}

?>