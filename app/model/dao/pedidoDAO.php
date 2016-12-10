<?php

include_once "./app/model/model.php";
require_once "./app/model/dto/pedidoDTO.php";

class PedidoDAO extends Model{

	public function crearPedido($cod_emisor, $cod_receptor, $fecha_entrega,  $tipo){
		$array = getdate();
        $fecha = $array['year']."-".$array['mon']."-".$array['mday'];

        $consulta="";
        $esConse = $this->esConsecionario($cod_emisor);
        if($esConse==0){
            $consulta = "INSERT INTO `pedido` (`cod_emisor`,`cod_receptor`,`fecha_pedido`,`fecha_entrega`,`tipo`,`estado`) 
                    values ('$cod_emisor', '$cod_receptor', '$fecha', '$fecha_entrega', '$tipo', 'Pendiente')";
        }else{
            $consulta = "INSERT INTO `pedido` (`cod_emisor`,`cod_receptor`,`fecha_pedido`,`fecha_entrega`,`tipo`,`estado`) 
                    values ('$cod_emisor', '$esConse', '$fecha', '$fecha_entrega', '$tipo', 'Pendiente')";
        }

		
		$this->connect();
		$this->query($consulta);
		$this->terminate();
		return $this->obtenerDatosPedido();
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

    public function obtenerDatosPedido(){
    	$consulta = "SELECT * FROM pedido order by cod_pedido desc limit 1";
        $this->connect();
    	$query = mysqli_fetch_array($this->query($consulta));
    	$this->terminate();
        $array = array($query['cod_pedido'],$this->consultarNombreEntidad($query['cod_emisor']), $this->consultarNombreEntidad($query['cod_receptor']),
                     $query['fecha_pedido'], $query['fecha_entrega'], $query['estado'], $query['tipo'], $query['cod_receptor'] );
        return $array;
    }

    public function buscarPedido($codigo){
    	$consulta = "SELECT * FROM pedido WHERE cod_pedido = $codigo";
    	$this->connect();
    	$query = mysqli_fetch_array($this->query($consulta));
    	$this->terminate();
    	return new PedidoDTO($query['cod_pedido'], $query['cod_emisor'], $query['cod_receptor'], $query['fecha_pedido'], $query['fecha_entrega'], $query['estado'], $query['tipo']);
    }

    public function consultarNombreEntidad($id){
        $this->connect();
        $query = mysqli_fetch_array($this->query("SELECT nombre FROM entidad WHERE codigo='$id'"));
        $this->terminate();
        return $query['nombre'];
    }

    public function esConsecionario($codigo){
        $this->connect();
        $query = mysqli_fetch_array($this->query("SELECT cod_sucursal FROM entidad WHERE codigo='$codigo'"));
        $this->terminate();
        return $query['cod_sucursal'];
    }
    
}

?>