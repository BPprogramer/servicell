<?php 

    namespace Controllers;

use Model\Reparacion;
use MVC\Router;

    class ClienteController{
        public static function index(Router $router){

            if(!is_cliente()){
               
                header('Location:/login');
            }
          
            $id = $_SESSION['id'];
           
            $reparacion = Reparacion::where('cliente_id', $id);
         
            if(!$reparacion){
               
                header('Location:/login');
            }
            

            $router->render('cliente/index',[
                'titulo'=>'Información sobre su dispositivo',
                'nombre'=>$_SESSION['nombre'],
                'reparacion'=>$reparacion
            ]);
        }
    }