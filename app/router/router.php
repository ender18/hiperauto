<?php

class Router {

    public $user;
    public $accion;

    public function __construct() {
        $this->user = new User();
        $this->accion = new Accion();
        

    }

    public function router() {
        if(isset($_GET["mode"])) {
            switch ($_GET["mode"]) {
                case "registrar":
                    $this->accion->registrar();
                    break;
                
                case "consultar":
                    $this->accion->consultar();
                    break;
                    
                default:
                    header("Location:index.php");
                    break;
            }
        } else if(isset($_POST["mode"])) {
            switch ($_POST["mode"]) {
                case "registrar-datos":
                    $this->accion->agregarFormRegistrar($_POST);
                    break;
                                    
                default:
                    header("Location:index.php");
                    break;
            }  
        } else {
            $this->user->index();  
        }
    }


}

?>