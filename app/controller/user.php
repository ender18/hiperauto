<?php

include_once "./app/controller/controller.php";

class User extends Controller {

    private $userModel;
    private $view;
    private $d;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->view = $this->getTemplate("./app/views/index.html");
    }

    public function index() {
        $inicio = $this->getTemplate("./app/views/inicio.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Inicio");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $inicio);
        $this->showView($this->view);
    }

// Metodos sucursal

    public function agregarSucursal() {
        $registroSucursal = $this->getTemplate("./app/views/accion/registroAccion.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Registrar Sucursal");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $registroSucursal);
        $this->showView($this->view);
    }

    public function agregarFormSucursal($form) {
        $mensaje = $this->userModel->registrarSucursal($form);
        $this->agregarSucursal();
        echo "<script language=JavaScript>alert('".$mensaje."');</script>";
        }

    public function consultarSucursales() {
        $registroSucursal = $this->getTemplate("./app/views/accion/listaSucursales.html");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $registroSucursal);
        $listadoSucursales = $this->userModel->mostrarSucursales();
        $tablaHtmlCompleta="";

        foreach($listadoSucursales as $element) {
            $tablaHtml=$this->getTemplate("./app/views/components/tablaSucursales.html");
            $tablaHtml = $this->renderView($tablaHtml, "{{codigo}}", $element->getCod_entidad());
            $tablaHtml = $this->renderView($tablaHtml, "{{nombre}}",$element->getNombre());
            $tablaHtml = $this->renderView($tablaHtml, "{{direccion}}",$element->getDireccion() );
            $tablaHtml = $this->renderView($tablaHtml, "{{ciudad}}", $element->getCiudad());
            $var1="<a href='index.php?mode=editarSucursal&id=".$element->getCod_entidad()."'>
            <button type='button' class='btn btn-warning'>Editar</button></a>&nbsp           
            <button onclick='realizarAjax(".$element->getCod_entidad().")' type='button' class='btn btn-danger borrar'>Borrar</button>";
            $tablaHtml = $this->renderView($tablaHtml, "{{opciones}}", $var1 );

        $tablaHtmlCompleta.=$tablaHtml;
        }
        $this->view = $this->renderView($this->view, "{{TITULO}}","Listado Sucursales");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $tablaHtmlCompleta);
        $this->showView($this->view);
         }

     public function editarSucursal($id){
         $tablaHtml=$this->getTemplate("./app/views/accion/editaSucursal.html");
         $element = $this->userModel->buscarSucursal($id);
         $tablaHtml = $this->renderView($tablaHtml, "{{codigo}}", $element[0]->getCod_entidad());
         $tablaHtml = $this->renderView($tablaHtml, "{{nombre}}",$element[0]->getNombre());
         $tablaHtml = $this->renderView($tablaHtml, "{{direccion}}",$element[0]->getDireccion() );
         $tablaHtml = $this->renderView($tablaHtml, "{{ciudad}}", $element[0]->getCiudad());
         $this->view = $this->renderView($this->view, "{{TITULO}}","Editar Sucursal");
         $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $tablaHtml);
         $this->showView($this->view);
     }

     public function editarSucursalFormulario($formulario){
        $mensaje = $this->userModel->editarSucursalFormulario($formulario);
        $this->consultarSucursales();
        echo "<script language=JavaScript>alert('".$mensaje."');</script>";
     }

     public function eliminarSucursal($form){
        $this->userModel->eliminarSucursal($form['id']);
        $listadoSucursales = $this->userModel->mostrarSucursales();
        $tablaHtmlCompleta="";
        foreach($listadoSucursales as $element) {
            $tablaHtml=$this->getTemplate("./app/views/components/tablaSucursales.html");
            $tablaHtml = $this->renderView($tablaHtml, "{{codigo}}", $element->getCod_entidad());
            $tablaHtml = $this->renderView($tablaHtml, "{{nombre}}",$element->getNombre());
            $tablaHtml = $this->renderView($tablaHtml, "{{direccion}}",$element->getDireccion() );
            $tablaHtml = $this->renderView($tablaHtml, "{{ciudad}}", $element->getCiudad());
            $var1="<a href='index.php?mode=editarSucursal&id=".$element->getCod_entidad()."'>
            <button type='button' class='btn btn-warning'>Editar</button></a>&nbsp           
            <button onclick='realizarAjax(".$element->getCod_entidad().")' type='button' class='btn btn-danger borrar'>Borrar</button>";
            $tablaHtml = $this->renderView($tablaHtml, "{{opciones}}", $var1 );

        $tablaHtmlCompleta.=$tablaHtml;
        }
        $this->showView($tablaHtmlCompleta);
     }

/* PEDIDO */

    public function realizarPedido(){
        $entidades = $this->userModel->mostrarEnditdades();
        $sucursales = $this->userModel->mostrarSucursales();
        $stringEntidades="";
        $stringSucursales="";
        foreach($entidades as $element){
                $stringEntidades.="<option value='".$element->getCod_entidad()."'>".$element->getNombre()."</option>";
        }
        
        foreach($sucursales as $element){
                $stringSucursales.="<option value='".$element->getCod_entidad()."'>".$element->getNombre()."</option>";
        }

        $tablaHtml=$this->getTemplate("./app/views/accion/realizaPedido.html");
        $tablaHtml=$this->renderView($tablaHtml, "{{ENTIDAD_CLIENTE}}", $stringEntidades);
        $tablaHtml=$this->renderView($tablaHtml, "{{SUCURSAL_PROVEEDORA}}", $stringSucursales);
        $this->view = $this->renderView($this->view, "{{TITULO}}","Realizar pedido");
        $this->view = $this->renderView($this->view,"{{CONTENIDO}}", $tablaHtml);
        $this->showView($this->view);
     }

     public function realizarPedidoFormulario($form){
         echo $form['fecha_entrega'];
         $fecha1 = explode("-", $form['fecha_entrega']);
         $array = getdate();
       
         if($form['cod_emisor']==$form['cod_receptor']){
             $mensaje="ERROR ! EL CLIENTE Y EL PROVEEDOR NO PUEDE SER EL MISMO, INTENTELO DE NUEVO";             
             echo "<script language=JavaScript>alert('".$mensaje."');</script>";
             $this->realizarPedido();
             
             }else if($fecha1[0]<$array['year'] && $fecha1[1]<$array['mon'] && $fecha1[2]<$array['mday']){
                 $mensaje="ERROR ! LA FECHA DE ENTREGA ES MENOR A LA DE HOY, INTENTELO DE NUEVO";             
             echo "<script language=JavaScript>alert('".$mensaje."');</script>";
             $this->realizarPedido();

             }
             
             
             
             else{


         $resultado = $this->userModel->hacerPedido($form['cod_emisor'], $form['cod_receptor'], $form['fecha_entrega'], $form['tipo']);
         $piezas = $this->userModel->verAlmacen($resultado[7]);

         $agregarPiezasPedido = $this->getTemplate("./app/views/accion/registrarPiezasPedido.html");
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{cod_pedido}}",$resultado[0]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{emisor}}",$resultado[1]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{receptor}}",$resultado[2]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{fecha_pedido}}",$resultado[3]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{fecha_entrega}}",$resultado[4]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{estado}}",$resultado[5]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{tipo}}",$resultado[6]);
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{cod_receptor}}",$resultado[7]);
         
         $htmlProductos="";         
        
          while($row = mysqli_fetch_array($piezas)){
            $htmlProductos.="<option value='".$row['cod_pieza']."'>".$row['cod_pieza']." - ".$row['nombre']." - Disp:".$row['stock']."</option>";

        }

        
        if($htmlProductos==""){
                $htmlProductos.="<option >NO HAY PRODUCTOS</option>";
                $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{deshabilitar}}","disabled");

        }
         
         $agregarPiezasPedido = $this->renderView($agregarPiezasPedido, "{{PRODUCTOS}}",$htmlProductos);
         $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar piezas");
         $this->view = $this->renderView($this->view,"{{CONTENIDO}}", $agregarPiezasPedido);
         $this->showView($this->view);
         }
     }


     public function mostrarPiezasPedidos($cod_pedido){
        $result = $this->userModel->listarPiezasPedido($cod_pedido);
        $tablaHtmlcompleta="";
        while($row = mysqli_fetch_array($result)){

            $tablaHtml=$this->getTemplate("./app/views/components/tabla-detalles-pedido.html");
             $tablaHtml = $this->renderView($tablaHtml, "{{cantidad}}",$row['cantidad']);
            $tablaHtml = $this->renderView($tablaHtml, "{{codigo}}", $row['cod_pieza']);
            $tablaHtml = $this->renderView($tablaHtml, "{{nombre}}",$row['nombre']);
            $tablaHtml = $this->renderView($tablaHtml, "{{opcion}}", "<button onclick='realizarAjax1($cod_pedido,".$row['cod_pieza'].")' type='button' class='btn btn-danger borrar'>Borrar</button>" );
            $tablaHtmlcompleta.=$tablaHtml;
        }
        if($tablaHtmlcompleta==""){
            $this->showView("<br><h4 id='titulo'>NO HAY PRODUCTOS EN ESTE PEDIDO</h4>");
            return;

        }
        $contenido=$this->getTemplate("./app/views/components/tabla-pedido.html");
        $contenido = $this->renderView($contenido, "{{CONTENIDO}}", $tablaHtmlcompleta);
        $this->showView($contenido);
     }

     public function agregarPiezaPedido($form){
         $sePuede = $this->userModel->agregarPiezaPedido($form['cod_receptor'], $form['cod_pedido'], $form['cod_pieza'] ,$form['cantidad']);
         if(!$sePuede){
             $mensaje="ERROR ! LA CANTIDAD SOLICITADA SUPERA LAS EXISTENCIAS, INTENTE DE NUEVO";             
             echo "<script language=JavaScript>alert('".$mensaje."');</script>";
         }
            $this->mostrarPiezasPedidos($form['cod_pedido']);
        
    }

    public function finalizarPedido(){
        $this->index();
        $mensaje="SU PEDIDO SE HA GUARDADO CON EXITO, PRONTO LE SERÁ DESPACHADO";             
             echo "<script language=JavaScript>alert('".$mensaje."');</script>";
    }


    public function eliminarPiezaPedido($get){
        $this->userModel->eliminarPiezaPedido($get);
        $this->mostrarPiezasPedidos($get['cod_pedido']);
    }


// Metodos pieza

    public function agregarPieza(){
        $registroPieza = $this->getTemplate("./app/views/accion/registroPieza.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}", "Registrar Pieza");
        $this->view = $this->renderView($this->view,"{{CONTENIDO}}", $registroPieza);
        $this->showView($this->view);
   }

    public function agregarFormPieza($form){
        $mensaje = $this->userModel->registrarPieza($form);
        $this->agregarPieza();
        echo "<script language=JavaScript>alert('".$mensaje."');</script>";

    }


    public function consultarPiezas(){
        $registroPieza=$this->getTemplate("./app/views/accion/listaPiezas.html");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $registroPieza);
        $listadoPiezas = $this->userModel->listarPieza();
        $tablaHtmlCompleta="";

            foreach ($listadoPiezas as $element) {
                $tablaHtml= $this->getTemplate("./app/views/components/tablaPiezas.html");
                $tablaHtml = $this->renderView($tablaHtml, "{{codigo}}", $element->getCod_pieza());
                $tablaHtml = $this->renderView($tablaHtml, "{{nombre}}", $element->getNombre());
                $var1="<a href='index.php?mode=editarPieza&id=".$element->getCod_pieza()."'>
                <button type='button' class='btn btn-warning'>Editar</button></a>&nbsp           
                <button onclick='realizarAjax(".$element->getCod_pieza().")' type='button' class='btn btn-danger borrar'>Borrar</button>";
                $tablaHtml = $this->renderView($tablaHtml, "{{opciones}}", $var1 );

            $tablaHtmlCompleta.=$tablaHtml;
            }

            $this->view = $this->renderView($this->view, "{{TITULO}}","Listado Piezas");
            $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $tablaHtmlCompleta);
            $this->showView($this->view);
    }

    public function editarPieza ($id) {
        $tablaHtml = $this->getTemplate("./app/views/accion/editaPieza.html");
        $element = $this->userModel->buscarPieza($id);
        $tablaHtml = renderView($tablaHtml, "{{codigo}}", $element[0]->getCod_pieza());
        $tablaHtml = renderView($tablaHtml, "{{nombre}}", $element[0]->getNombre());
        $this->view = $this->renderView($this->view, "{{TITULO}}","Editar Pieza");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $tablaHtml);
        $this->showView($this->view);
    }

    public function editarPiezaFormulario($formulario){
        $mensaje = $this->userModel->editarPiezaFormulario($formulario);
        $this->consultarPiezas();
        echo "<script language=JavaScript>alert('".$mensaje."');</script>";
     }
    public function eliminarPieza($form){
        $this->userModel->eliminarPieza($form['id']);
        $listadoPiezas = $this->userModel->mostrarPieza();
        $tablaHtmlCompleta="";
        foreach($listadoPiezas as $element) {
            $tablaHtml=$this->getTemplate("./app/views/components/tablaPiezas.html");
            $tablaHtml = $this->renderView($tablaHtml, "{{codigo}}", $element->getCod_pieza());
            $tablaHtml = $this->renderView($tablaHtml, "{{nombre}}",$element->getNombre());
            $var1="<a href='index.php?mode=editarPieza&id=".$element->getCod_pieza()."'>
            <button type='button' class='btn btn-warning'>Editar</button></a>&nbsp           
            <button onclick='realizarAjax(".$element->getCod_pieza().")' type='button' class='btn btn-danger borrar'>Borrar</button>";
            $tablaHtml = $this->renderView($tablaHtml, "{{opciones}}", $var1 );

        $tablaHtmlCompleta.=$tablaHtml;
        }
        $this->showView($tablaHtmlCompleta);
     }

    public function inicioSesion() {
        $menu;
        $login = $this->getTemplate("./app/views/login.html");
        if((!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null)){

            $menu = $this->getTemplate("./app/views/components/menu-logout.html");
        }else{
            header("Location:index.php");
            return;
        }
        $this->view = $this->renderView($this->view, "{{TITULO}}", "Iniciar Sesión");
        $this->view = $this->renderView($this->view, "{{SESION}}", $menu);
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $login);
        $this->showView($this->view);
    }

    public function login($user, $password) {
        $pass = sha1($password);
        $log = $this->userModel->login($user, $pass);
        if($log) {
            $this->index();
        } else {
            echo "<script> alert('La clave y el usuario no coinciden');</script>";
            $this->inicioSesion();
        }
    }
}

?>