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
            $tablaHtml = $this->renderView($tablaHtml, "{{opciones}}", "<a href='"."index.php?mode=editarSucursal&id=".$element->getCod_entidad()."'>
            <button type="."'button'"." class="."'btn btn-warning'".">Editar</button></a>&nbsp <button type="."'button'"." class="."'btn btn-danger'"."
            >Borrar</button>");
        $tablaHtmlCompleta.=$tablaHtml;
        }
        $this->view = $this->renderView($this->view, "{{TITULO}}","Listado Sucursales");
        $this->view = $this->renderView($this->view, "{{CONTENIDO}}", $tablaHtmlCompleta);
        $this->showView($this->view);
         }

     public function editarSucursal($id){




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