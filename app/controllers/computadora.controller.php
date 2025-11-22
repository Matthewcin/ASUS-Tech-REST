<?php
require_once 'app/models/computadora.model.php';
require_once 'app/models/categorias.model.php';
require_once 'app/middlewares/autch.middleware.php';

class ComputadoraController {
    private $modelComputadoras;
    private $modelCategorias;

    function __construct() {
        $this->modelComputadoras = new ComputadoraModel();
        $this->modelCategorias = new categoriasModel();
    }

    public function obtenerComputadorasYfiltrar($req, $res) { 
    // Si el usuario NO envió categoria_id, entonces considéralo como no filtrado osea null 
    $limit = $req->query->limit ?? null;
    $categoria_id = $req->query->categoria_id ?? null;
    $order = $req->query->orderBy ?? null;

    //$order pregunto si no esta vacio 
    if($order && $order !== 'ASC' && $order !== 'DESC'){
        return $res->json("El parámetro orderBy no puede estar vacio o debe ser ASC o DESC", 400);
    }

    if ($categoria_id) {
    $validarCategoria = $this->modelCategorias->obtenerCategoriaPorId($categoria_id);
    $obtenerComputadoras = count($this->modelCategorias->obtenerComputadorasPorCategoria($categoria_id));
    if(!$validarCategoria || $obtenerComputadoras < 1) {
        return $res->json("la categoria no existe o no hay computadoras en la categoria",404); 
    }
}

    // Si hay categoria + order
    if ($categoria_id && $order) {
        $computadoras = $this->modelCategorias->obtenerComputadorasPorCategoriaOrdenado($categoria_id, $order);
        return $res->json($computadoras);
        //si solo hay categoria
    }else if ($categoria_id ) {
        $computadoras = $this->modelCategorias->obtenerComputadorasPorCategoria($categoria_id);
        // si solo hay orden
    }else if ($order) {
        $computadoras = $this->modelComputadoras->ordenarComputadoras($order);
    }else {
        // si no hay filtros, traemos todas
        $computadoras = $this->modelComputadoras->obtenerComputadoras();
    }
    // Aplicar limit si existe
    if ($limit) {
    $computadoras = array_slice($computadoras, 0, $limit);
    }
    return $res->json($computadoras);
    }

    public function obtenerComputadoraPorID($req, $res) {
        $id = $req->params->id;
        $computadora = $this->modelComputadoras->obtenerComputadorasID($id);

        if (!$computadora) {
            return $res->json("error No existe la computadora con id=$id", 404);
        }

        return $res->json($computadora, 200);
    }

    public function agregarComputadora($req, $res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        if (empty($req->body->modelo) || empty($req->body->descripcion) || empty($req->body->precio) || empty($req->body->categoria_id) || empty($req->body->imagen)) {
            return $res->json("error Faltan datos obligatorios", 400);
        }

        $modelo = $req->body->modelo;
        $descripcion = $req->body->descripcion;
        $precio = $req->body->precio;
        $categoria_id = $req->body->categoria_id;
        $imagen = $req->body->imagen;

        $id = $this->modelComputadoras->agregarComputadoras($modelo,$descripcion,$precio,$categoria_id,$imagen);

        if(!$id) {
            return $res->json("la computadora no se pudo crear correctamente ", 500);
        }

        $nueva = $this->modelComputadoras->obtenerComputadorasID($id);
        return $res->json($nueva, 201);
    }

    public function actualizarComputadora($req, $res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $id = $req->params->id;
        $computadora = $this->modelComputadoras->obtenerComputadorasID($id);

        if (!$computadora) {
            return $res->json("error Computadora no encontrada", 404);
        }

        if (empty($req->body->modelo) || empty($req->body->descripcion) || empty($req->body->precio) || empty($req->body->categoria_id) || empty($req->body->imagen)) {
            return $res->json("error Faltan datos obligatorios", 400);
        }

        $modelo = $req->body->modelo;
        $descripcion = $req->body->descripcion;
        $precio = $req->body->precio;
        $categoria_id = $req->body->categoria_id;
        $imagen = $req->body->imagen;

        $this->modelComputadoras->actualizarComputadorax($id,$modelo,$descripcion,$precio,$categoria_id,$imagen);

        $actualizada = $this->modelComputadoras->obtenerComputadorasID($id);
        return $res->json($actualizada, 200);
    }

    public function eliminarComputadora($req, $res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $id = $req->params->id;
        $computadora = $this->modelComputadoras->obtenerComputadorasID($id);

        if (!$computadora) {
            return $res->json("error Computadora no encontrada", 404);
        }

        $this->modelComputadoras->eliminarComputadorax($id);
        return $res->json("Computadora eliminada correctamente", 200);
    }
}
