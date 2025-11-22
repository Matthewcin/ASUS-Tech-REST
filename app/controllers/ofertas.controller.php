<?php
require_once 'app/models/ofertas.model.php';
require_once 'app/models/ofertasComputadoras.model.php';
class ofertasController {
    private $modelOferta;
    private $modelOfertasComputadoras;

    function __construct() {
        $this->modelOferta = new ofertasModel();
        $this->modelOfertasComputadoras = new ofertasComputadorasModel();
    }

    public function obtenerOfertas($req, $res) {
        $obtenerOfertas = $this->modelOferta->obtenerOfertas();

        if (!$obtenerOfertas) {
            return $res->json("no se encontraron ofertas disponibles", 404);
        }

        return $res->json($obtenerOfertas, 200);
    }

    public function obtenerOfertasId($req,$res) {
        $id = $req->params->id;
        $obtener = $this->modelOferta->obtenerOfertasId($id);

        if(!$obtener) {
            return $res->json("la oferta seleccionada no se pudo obtener correctamente", 404);
        }

        return $res->json($obtener,200);
    }

    public function agregarOferta($req, $res){
        if (!verificarCredencialesAPI($req, $res))return;
    
        if (empty($req->body->titulo) || empty($req->body->descripcion) || empty($req->body->fecha_inicio) ||empty($req->body->fecha_fin) || empty($req->body->img)) {
            return $res->json("Faltan datos obligatorios", 400);
        }

        $titulo= $req->body->titulo;
        $descripcion= $req->body->descripcion;
        $fecha_inicio= $req->body->fecha_inicio;
        $fecha_fin= $req->body->fecha_fin;
        $img= $req->body->img;
    
        $id = $this->modelOferta->crearOferta($titulo, $descripcion, $fecha_inicio, $fecha_fin, $img);

        if (!$id) {
            return $res->json("No se pudo crear la oferta correctamente", 500);
        }

        $oferta = $this->modelOferta->obtenerOfertasId($id);
        return $res->json($oferta, 201);
    }
    
    public function actualizarOferta($req,$res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $id = $req->params->id;
        $obtener = $this->modelOferta->obtenerOfertasId($id);

        if(!$obtener) {
            return $res->json("no se pudo encontrar la oferta seleccionada",400);
        }

        if(empty($req->body->titulo) || empty($req->body->descripcion) || empty($req->body->fecha_inicio) ||empty($req->body->fecha_fin) || empty($req->body->img)) {
            return $res->json("faltan datos obligatorios",400);
        }

        $titulo= $req->body->titulo;
        $descripcion= $req->body->descripcion;
        $fecha_inicio= $req->body->fecha_inicio;
        $fecha_fin= $req->body->fecha_fin;
        $img= $req->body->img;

        $actualizada = $this->modelOferta->actualizarOferta($titulo,$descripcion,$fecha_inicio,$fecha_fin,$img,$id);

        if(!$actualizada) {
            return $res->json("no se pudo actualizar correctamente la oferta",500);
        }

        return $res->json($actualizada,200);
    }

    public function eliminarOferta($req, $res) {
        if(!verificarCredencialesAPI($req, $res)) return;

        $id = $req->params->id;
        $oferta = $this->modelOferta->obtenerOfertasId($id);

        if(!$oferta) {
            return $res->json("la oferta selecciona no existe", 404);
        }

        $computadoras = $this->modelOfertasComputadoras->obtenerComputadorasPorOferta($id);

        if(!empty($computadoras)) {
            return $res->json("no se puede eliminar la oferta por que hay productos seleccionados", 400);
        }

        $this->modelOferta->borrarOferta($id);

        return $res->json("la oferta se elimino correctamente", 200);
    } 
}