<?php

class PedidoDTO{
    
    private $cod_pedido;
    private $cod_emisor;
    private $cod_receptro;
    private $fecha_pedido;
    private $fecha_entrega;
    private $estado;
    private $tipo;
    
    public function __construct($cod_pedido, $cod_emisor, $cod_receptro, $fecha_pedido, $fecha_entrega, $estado, $tipo){
        $this->cod_pedido = $cod_pedido;
        $this->cod_emisor = $cod_emisor;
        $this->cod_receptor = $cod_receptor;
        $this->fecha_pedido = $fecha_pedido;
        $this->fecha_entrega = $fecha_entrega;
        $this->estado = $estado;
        $this->tipo = $tipo;
    }

    public function getCod_pedido(){
        return $this->cod_pedido;
    }
    
    public function setCod_pedido($cod_pedido){
        $this->cod_pedido = $cod_pedido;
    }
    
    public function getCod_emisor(){
        return $this->cod_emisor;
    }
    
    public function setCod_emisor($cod_emisor){
        $this->cod_emisor = $cod_emisor;
    }
    
    public function getCod_receptor(){
        return $this->cod_receptor;
    }
    
    public function setCod_receptor($cod_receptor){
        $this->cod_receptor = $cod_receptor;
    }
    
    public function getFecha_pedido(){
        return $this->fecha_pedido;
    }
    
    public function setFecha_pedido($fecha_pedido){
        $this->fecha_pedido = $fecha_pedido;
    }
    
    public function getFecha_entrega(){
        return $this->fecha_entrega;
    }
    
    public function setFecha_entrega($fecha_entrega){
        $this->fecha_entrega = $fecha_entrega;
    }
    
    public function getEstado(){
        return $this->estado;
    }
    
    public function setEstado($estado){
        $this->estado = $estado;
    }
    
    public function getTipo(){
        return $this->tipo;
    }
    
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    
}

?>