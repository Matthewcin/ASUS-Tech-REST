<?php
require_once 'app/models/ofertas.model.php';
require_once 'app/models/ofertasComputadoras.model.php';

class ofertasComputadorasController {
    private $modelOfertasComputadora;
    private $modelOferta;

    public function __construct() {
        $this->modelOfertasComputadora = new ofertasComputadorasModel();
        $this->modelOferta = new ofertasModel();
    }

    public function obtenerComputadorasOferta($req, $res) {
        $computadoras = $this->modelOfertasComputadora->obtenerComputadorasPorOferta();

        if(empty($computadoras)) {
            return $res->json("No hay computadoras en esta oferta", 200);
        }

        return $res->json($computadoras, 200);
    }

    public function obtenerComputadorasOfertaId($req, $res) {
        $id = $req->params->id; 

        $computadora = $this->modelOfertasComputadora->obtenerComputadorasPorOfertaId($id);
        if (!$computadora) {
            return $res->json("No se encontró la notebook con ese ID", 404);
        }

        return $res->json($computadora, 200);
    }

    public function agregarComputadoraOferta($req,$res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $idOferta = $req->params->idOferta;
        $idComputadora = $req->params->idComputadora;

        $oferta = $this->modelOferta->obtenerOfertasId($idOferta);
        if(!$oferta) {
            return $res->json("La oferta no existe", 404);
        }

        $existe = $this->modelOfertasComputadora->computadorasTieneOferta($idComputadora);
        if($existe) {
            return $res->json("la computadora ya pertenece a una oferta",400);
        }

        if(empty($req->body->precio_descuento)) {
            return $res->json("falta agregar el precio de descuento",400);
        }

        $precioDescuento = $req->body->precio_descuento;
        $precioOriginal = $this->modelOfertasComputadora->obtenerPrecioOriginal($idComputadora);

        if(!$precioOriginal) {
            return $res->json("la computadora no existe ",404);
        }

        if($precioDescuento >= $precioOriginal->precio) {
            return $res->json("El precio con descuento debe ser menor que el precio original", 400);
        }

        $computadoraOferta = $this->modelOfertasComputadora->agregarComputadoraOferta($idOferta,$idComputadora,$precioDescuento);

        if(!$computadoraOferta) {
            return $res->json("la computadora no se pudo agregar correctamente",500);
        }

        $obtenerComputadora = $this->modelOfertasComputadora->obtenerComputadorasPorOfertaId($idComputadora);

        return $res->json($obtenerComputadora,201);
    }

    public function actualizarComputadoraOferta($req, $res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $idOferta = $req->params->idOferta;
        $idComputadora = $req->params->idComputadora;

        $oferta = $this->modelOferta->obtenerOfertasId($idOferta);
        if(!$oferta) {
            return $res->json("La oferta no existe", 404);
        }

        $existe = $this->modelOfertasComputadora->computadorasTieneOferta($idComputadora);
        if(!$existe) {
            return $res->json("La computadora no pertenece a ninguna oferta", 400);
        }
  
        if(empty($req->body->precio_descuento)) {
            return $res->json("Falta el precio de descuento", 400);
        }

        $precio_descuento = $req->body->precio_descuento;

        $precioOriginal = $this->modelOfertasComputadora->obtenerPrecioOriginal($idComputadora);
        if(!$precioOriginal) {
            return $res->json("La computadora no existe", 404);
        }

        if($precio_descuento >= $precioOriginal->precio) {
            return $res->json("El precio de descuento debe ser menor que el precio original", 400);
        }

        $actualizada = $this->modelOfertasComputadora->actualizarDeComputadoraOferta($precio_descuento,$idComputadora);

        if(!$actualizada) {
            return $res->json("No se pudo actualizar correctamente la oferta", 500);
        }

        $obtenerComputadora = $this->modelOfertasComputadora->obtenerComputadorasPorOfertaId($idComputadora);

        return $res->json($obtenerComputadora, 200);
    }

    public function eliminarComputadoraOferta($req,$res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $idOferta = $req->params->idOferta;
        $idComputadora = $req->params->idComputadora;

        $oferta = $this->modelOferta->obtenerOfertasId($idOferta);
        if(!$oferta) {
            return $res->json("La oferta no existe", 404);
        }

        $existe = $this->modelOfertasComputadora->computadorasTieneOferta($idComputadora);
        if(!$existe) {
            return $res->json("La computadora no pertenece a ninguna oferta", 400);
        }

        $computadora = $this->modelOfertasComputadora->eliminarComputadoraDeOferta($idComputadora);

        if(!$computadora) {
            return $res->json("no se pudo elimnar correctamente",500);
        }

        return $res->json("computadora eliminada correctamente",200);
    }

}
