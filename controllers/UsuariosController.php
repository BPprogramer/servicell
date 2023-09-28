<?php

namespace Controllers;


use MVC\Router;

class UsuariosController {

    public static function index(Router $router){
        if(!is_admin()){
            header('Location:/login');
        }
        
        
        $router->render('auth/index', [
            'titulo' => 'Usuarios',
            'nombre'=>$_SESSION['nombre']
        
        ]);
    }


    public static function login(Router $router) {
     
        if(is_admin()){
            header('Location:/inicio');
        }
   
        if(is_cliente()){
            header('Location:/clientes');
            return;
        }
    

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }
    public static function redireccionLogin(){
        header('Location:/login');
    }

}