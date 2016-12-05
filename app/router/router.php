<?php

class Router {

    public $user;

    public function __construct() {
        $this->user = new User();
    }

    public function router() {
        if(isset($_GET["mode"])) {
            switch ($_GET["mode"]) {
                case "agregarSucursal":
                    $this->user->agregarSucursal();
                    break;
                
                case "consultarSucursales":
                    $this->user->consultarSucursales();
                    break;
                    
                default:
                    header("Location:index.php");
                    break;
            }
        } else if(isset($_POST["mode"])) {
            switch ($_POST["mode"]) {
                case "agregarSucursalFormulario":
                    $this->user->agregarFormSucursal($_POST);
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