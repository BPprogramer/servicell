<?php 

    namespace Controllers;

use MVC\Router;

    class DashboardController{
        public static function index(Router $router){
            // session_start();
            if(!is_admin()){
                header('Location:/login');
            }
            $router->render('inicio/index',[
                'titulo'=>'Inicio',
                'nombre'=>$_SESSION['nombre']
            ]);
        }
    }

    
