<?php

include_once "./app/controller/controller.php";

class User extends Controller {

    private $userModel;
    private $view;


    public function __construct() {
        $this->userModel = new UserModel();
        $this->view = $this->getTemplate("./app/views/index.html");
    }

    public function index() {
        $this->view = $this->renderView($this->view, "{{TITLE}}","REGISTRAR ENTIDAD");
        $this->view = $this->renderView($this->view, "{{CONTENT}}","NOMBRE ENTIDAD");
        $this->showView($this->view);            
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