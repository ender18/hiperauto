
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

                case "editarSucursal":
                    $this->user->editarSucursal($_GET["id"]);
                    break;

                case "eliminarSucursal1":
                    $this->user->eliminarSucursal($_GET);
                    break;
                    
                case "agregarPieza":
                    $this->user->agregarPieza();
                    break;

                case "consultarPieza":
                    $this->user->consultarPiezas();
                    break;

                case "realizarPedido":
                    $this->user->realizarPedido();
                    break;

                case "eliminarPiezaPedido":
                    $this->user->eliminarPiezaPedido($_GET);
                    break;

                case "finalizarPedido":
                    $this->user->finalizarPedido();
                    break;
                case "eliminarPieza":
                    $this->user->eliminarPieza($_GET);
                    break;
                case "editarPieza":
                    $this->user->editarPieza($_GET["id"]);
                    break;

                case "consultarPedidos":
                    $this->user->consultarPedidos();
                    break;

                case "eliminarPedido":
                    $this->user->eliminarPedido($_GET);
                    break;

                case "verDetallePedido":
                    $this->user->verDetallePedido($_GET);
                    break;

                case "editarPedido":
                    $this->user->editarPedido($_GET);
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

                case "editarSucursalFormulario":
                    $this->user->editarSucursalFormulario($_POST);
                    break;

                case "agregarPiezaFormulario":
                    $this->user->agregarFormPieza($_POST);         
                    break;

                case "editarPiezaFormulario":
                    $this->user->editarPiezaFormulario($_POST);
                    break;
                
                case "realizarPedidoFormulario":
                    $this->user->realizarPedidoFormulario($_POST);
                    break;

                case "agregarPiezaPedido":
                    $this->user->agregarPiezaPedido($_POST);
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