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

   public function obtenerComputadorasYfiltrar($req, $res) { // ARREGLADO <--
    // Obtengo los paramotros requeridos y si no existen dejo con ?? los default
    $orderBy = $req->query->orderBy ?? 'id'; // si el usuario no setea que tipo de orderBy, sera por ID de Notebooks
    $order = $req->query->order ?? 'ASC'; // Si el usuario no setea el order, entonces será siempre ASCENDENTE (de arriba para abajo)
    $limit = $req->query->limit ?? null; // el limite puede ser null (osea todo)
    $categoria_id = $req->query->categoria_id ?? null; // lo moismo que el limite

    $columnasPermitidas = ['id', 'modelo', 'precio', 'categoria_id'];
    if (!in_array($orderBy, $columnasPermitidas)) {
        $orderBy = 'id'; // si el usuario manda algo que no es, por defecto será id
    }

    // aca valido que sea DESC o ASC unicamente, y ademas el strtoupper lo que hace es PONERLO EN MAYUSCULAS
    if (strtoupper($order) !== 'DESC') {
        $order = 'ASC';
    }

    $computadoras = $this->modelComputadoras->ordenarComputadoras($categoria_id, $orderBy, $order, $limit);

    return $res->json($computadoras, 200);
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

        if (!isset($req->body) || $req->body === null) { // AGREGUE ESTO POR SI EL USUARIO NO ENVIA BIEN EL BODY VIA POST
        return $res->json("el json enviado por el body esta mal hecho o vacio", 400);
    }

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
