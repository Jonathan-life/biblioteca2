<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página principal
$routes->get('/', 'Home::index');

// 📌 Grupo de rutas para CRUD de recursos
$routes->group('recursos', ['namespace' => 'App\Controllers'], function($routes){
    $routes->get('/', 'Recursos::index');                 // Listar
    $routes->get('crear', 'Recursos::crear');             // Formulario crear
    $routes->post('guardar', 'Recursos::guardar');        // Guardar
    $routes->get('editar/(:num)', 'Recursos::editar/$1'); // Formulario editar
    $routes->post('actualizar/(:num)', 'Recursos::actualizar/$1'); // Actualizar
    $routes->get('eliminar/(:num)', 'Recursos::eliminar/$1'); // Eliminar
});
