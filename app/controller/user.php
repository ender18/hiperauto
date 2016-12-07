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
        $this->registrarPieza();
        echo "<script language=JavaScript>alert('".$mensaje."');</script>";

    }

    public function consultarPiezas(){
        $registroPieza=$this->getTemplate("./app/views/accion/listaPiezas.html");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $registroPieza);
        $listadoPiezas = $this->userModel->listarPieza();
        $tablaHtml="";

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