<?php

namespace Controllers;
use Model\Reparacion;


use MVC\Router;

class ReparacionController {

    public static function index(Router $router){
        if(!is_admin()){
            header('Location:/login');
        }
        
        $router->render('reparacion/index', [
            'titulo' => 'Reparaciones',
            'nombre'=>$_SESSION['nombre']
        
        ]);
    }
    public static function reparacion(Router $router){
       
        if(!is_admin()){
            header('Location:/login');
        }
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id){
            header('Location:/reparaciones');
        }
        $reparacion = Reparacion::find($id);
        
        if(!$reparacion){
            header('Location:/reparaciones');
        }
   
        
        $router->render('reparacion/reparacion', [
            'titulo' => 'información sobre esta Reparacion',
            'nombre'=>$_SESSION['nombre'],
            'reparacion'=>$reparacion
        
        ]);
    }



}