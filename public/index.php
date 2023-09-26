<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ApiFacturas;
use Controllers\ApiInicio;
use Controllers\ApiReparaciones;
use Controllers\ApiUsuarios;
use Controllers\ClienteController;
use MVC\Router;
use Controllers\UsuariosController;
use Controllers\DashboardController;
use Controllers\ReparacionController;

$router = new Router();


// Login
$router->get('/', [UsuariosController::class, 'redireccionLogin']);
$router->get('/login', [UsuariosController::class, 'login']);


//DasboardController

$router->get('/inicio',[DashboardController::class, 'index']);
$router->get('/reparaciones', [ReparacionController::class, 'index']);
$router->get('/reparaciones/reparacion', [ReparacionController::class, 'reparacion']);
$router->get('/usuarios', [UsuariosController::class, 'index']);




// $router->post('/usuario/comprobar-email', [UsuariosController::class, 'comprobarEmail']);


//api reparaciones
$router->get('/api/reparaciones', [ApiReparaciones::class, 'reparaciones']);
$router->post('/api/reparacion/crear', [ApiReparaciones::class, 'crear']);
$router->post('/api/reparacion/editar', [ApiReparaciones::class, 'editar']);
$router->post('/api/reparacion/eliminar', [ApiReparaciones::class, 'eliminar']);
$router->get('/api/reparacion', [ApiReparaciones::class, 'reparacion']);
$router->post('/api/reparacion/crear-costo', [ApiReparaciones::class, 'crearCosto']);
$router->post('/api/reparacion/editar-costo', [ApiReparaciones::class, 'editarCosto']);
$router->post('/api/reparacion/eliminar-costo', [ApiReparaciones::class, 'eliminarCosto']);
$router->get('/api/reparacion/costos', [ApiReparaciones::class, 'costos']);
$router->post('/api/reparacion/crear-ingreso', [ApiReparaciones::class, 'crearIngreso']);
$router->post('/api/reparacion/editar-ingreso', [ApiReparaciones::class, 'editarIngreso']);
$router->post('/api/reparacion/eliminar-ingreso', [ApiReparaciones::class, 'eliminarIngreso']);
$router->get('/api/reparacion/ingresos', [ApiReparaciones::class, 'ingresos']);
$router->post('/api/reparacion/crear-notificacion', [ApiReparaciones::class, 'crearNotificacion']);
$router->get('/api/reparacion/notificaciones', [ApiReparaciones::class, 'notificaciones']);

$router->get('/api/reparacion/estado-actual', [ApiReparaciones::class, 'estadoActual']);
$router->post('/api/reparacion/cambiar-estado', [ApiReparaciones::class, 'cambiarEstado']);

//API Usuarios
$router->get('/api/usuarios', [ApiUsuarios::class, 'usuarios']);
$router->get('/api/usuario', [ApiUsuarios::class, 'consultarUsuario']);
$router->post('/usuario/crear', [ApiUsuarios::class, 'crear']);
$router->post('/usuario/editar', [ApiUsuarios::class, 'editar']);
$router->post('/usuario/eliminar', [ApiUsuarios::class, 'eliminar']);
$router->post('/usuario/login', [ApiUsuarios::class, 'login']);
$router->get('/usuario/logout', [ApiUsuarios::class, 'logout']);

//Clientes
$router->get('/clientes', [ClienteController::class, 'index']);

$router->get('/api/dashboard', [ApiInicio::class, 'dashboard']);

//facturas

$router->get('/api/factura', [ApiFacturas::class, 'facturaInicial']);
$router->get('/api/factura-finalizada', [ApiFacturas::class, 'facturaFinal']);








$router->comprobarRutas();