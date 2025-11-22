<?php
require_once 'app/models/categorias.model.php';
require_once 'app/middlewares/autch.middleware.php';

class categoriasController{
    private $model;

    function __construct(){
        $this->model = new categoriasModel;
    }

    public function agregarCategorias($req,$res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        if(empty($req->body->categoria) || empty($req->body->descripcion)) {
            return $res->json("faltan datos obligatorios " , 400);
        }

        $categoria = $req->body->categoria;
        $descripcion = $req->body->descripcion;

        $agregar = $this->model->agregarCategorias($categoria,$descripcion);

        if(!$agregar) {
            return $res->json("no se pudo crear la categoria correctamente ", 500);
        }

        $obtener = $this->model->obtenerCategoriaPorId($agregar);
        $res->json($obtener,201);
    }


    public function actualizarCategoria($req,$res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $id = $req->params->id;
        $categoria = $this->model->obtenerCategoriaPorId($id);

        if(!$categoria) {
            return $res->json("la categoria seleccionada no existe",404);
        }

        if(empty($req->body->categoria) || empty($req->body->descripcion)) {
            return $res->json("faltan datos obligatorios",400);
        }

        $obCategoria = $req->body->categoria;
        $descripcion = $req->body->descripcion;

        $this->model->actualizarCategoria($id,$obCategoria,$descripcion);

        $actualizada = $this->model->obtenerCategoriaPorId($id);
        $res->json($actualizada,200);
    }

    public function borrarCategoria($req,$res) {
        if(!verificarCredencialesAPI($req,$res)) return;
        $id = $req->params->id;
        $obtener = $this->model->obtenerCategoriaPorId($id);
        $notebooks = $this->model->obtenerComputadorasPorCategoria($id);

        if(!$obtener) {
            return $res->json("la categoria selecciona no existe",400);
        }

        if(!empty($notebooks)) {
            return $res->json("No se puede borrar la categoría porque tiene productos asociados",400);
        }

        $this->model->borrarCategoria($id);
        $res->json("la categoria se elimino correctamente",200);
    }

    public function mostrarCategorias($req,$res){
        $obtenerCategorias = $this->model->mostrarCategorias();
        if(!$obtenerCategorias){
            $res->json("No se encontraron categorias disponibles, agregue almenos una e intentelo nuevamente", 404);
        }

        $res->json($obtenerCategorias);
    }
    
    public function mostrarCategoriasId($req,$res){
        $id = $req->params->id;
        $obtenerCategorias = $this->model->mostrarCategoriasPorId($id);
        if(!$obtenerCategorias){
            $res->json("No se encontraro la categoria seleccionada", 404);
        }

        $res->json($obtenerCategorias);
    }
}