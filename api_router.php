<?php
require_once 'libs/router/router.php';
require_once 'app/controllers/categorias.controller.php';
require_once 'app/controllers/computadora.controller.php';
require_once 'app/controllers/ofertas.controller.php';
require_once 'app/controllers/ofertasComputadoras.controller.php';
$router = new Router();

$router->addRoute('computadoras',     'GET',      'computadoraController',      'obtenerComputadorasYfiltrar');
$router->addRoute('computadoras/:id',     'GET',      'computadoraController',      'obtenerComputadoraPorID');
$router->addRoute('computadoras',     'POST',      'computadoraController',      'agregarComputadora');
$router->addRoute('computadoras/:id',     'PUT',      'computadoraController',      'actualizarComputadora');
$router->addRoute('computadoras/:id',     'DELETE',      'computadoraController',      'eliminarComputadora');

$router->addRoute('categorias',     'GET',      'categoriasController',      'mostrarCategorias');
$router->addRoute('categorias/:id',     'GET',      'categoriasController',      'mostrarCategoriasId');
$router->addRoute('categorias/:id',  'PUT',    'categoriasController',      'actualizarCategoria');
$router->addRoute('categorias',     'POST',      'categoriasController',      'agregarCategoria');
$router->addRoute('categorias/:id',     'DELETE',      'categoriasController',      'borrarCategoria');

$router->addRoute('ofertas',     'GET',      'ofertasController',      'obtenerOfertas');
$router->addRoute('ofertas/:id',     'GET',      'ofertasController',      'obtenerOfertasId');
$router->addRoute('ofertas',     'POST',      'ofertasController',      'agregarOferta');
$router->addRoute('ofertas/:id',     'PUT',      'ofertasController',      'actualizarOferta');
$router->addRoute('ofertas/:id',     'DELETE',      'ofertasController',      'eliminarOferta');

$router->addRoute('ofertasComputadoras',     'GET',      'ofertasComputadorasController',      'obtenerComputadorasOferta');
$router->addRoute('ofertasComputadoras/:id',     'GET',      'ofertasComputadorasController',      'obtenerComputadorasOfertaId');
$router->addRoute('ofertas/:idOferta/computadoras/:idComputadora',     'POST',      'ofertasComputadorasController',      'agregarComputadoraOferta');
$router->addRoute('ofertas/:idOferta/computadoras/:idComputadora',     'PUT',      'ofertasComputadorasController',      'actualizarComputadoraOferta');
$router->addRoute('ofertas/:idOferta/computadoras/:idComputadora',     'DELETE',      'ofertasComputadorasController',      'eliminarComputadoraOferta');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
