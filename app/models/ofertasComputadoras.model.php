<?php
class ofertasComputadorasModel {
    protected $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_asus;charset=utf8', 'root','');
    }

    public function obtenerComputadorasPorOferta() {
        $obtener = $this->db->prepare("SELECT n.*,onb.precio_descuento FROM notebooks AS n JOIN oferta_notebooks AS onb ON n.id = onb.id_notebook JOIN ofertas AS o ON onb.id_oferta = o.id");
        $obtener->execute([]);
        return $obtener->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerComputadorasPorOfertaId($id) {
        $obtener = $this->db->prepare("SELECT n.*,onb.id AS id_oferta_notebook,onb.id_oferta,onb.precio_descuento FROM notebooks AS n JOIN oferta_notebooks AS onb ON n.id = onb.id_notebook WHERE n.id = ?");
        $obtener->execute([$id]);
        return $obtener->fetch(PDO::FETCH_OBJ);
    }

    public function computadorasTieneOferta($id_computadora) {
        $existe = $this->db->prepare("SELECT * FROM oferta_notebooks WHERE id_notebook = ?");
        $existe->execute([$id_computadora]);
        return $existe->fetch(PDO::FETCH_OBJ);
    }

    public function obtenerPrecioOriginal($id_computadora) {
        $obtener = $this->db->prepare("SELECT precio FROM notebooks WHERE id = ?");
        $obtener->execute([$id_computadora]);
        return $obtener->fetch(PDO::FETCH_OBJ);
    }

    public function agregarComputadoraOferta($id_oferta,$id_computadora,$precio_descuento) {
        $agregar = $this->db->prepare("INSERT INTO oferta_notebooks (id_oferta,id_notebook,precio_descuento) VALUES (?,?,?)");
        $agregar->execute([$id_oferta,$id_computadora,$precio_descuento]);
        return $this->db->lastInsertId();
    }

    public function actualizarDeComputadoraOferta($precio_descuento,$id_computadora) {
        $actualizar = $this->db->prepare("UPDATE oferta_notebooks SET precio_descuento = ? WHERE id_notebook = ?");
        $actualizar->execute([$precio_descuento,$id_computadora]);
        return $actualizar->rowCount(); // Cantidad de filas actualizadas
    }

    public function eliminarComputadoraDeOferta($id_computadora) {
        $borrar = $this->db->prepare("DELETE FROM oferta_notebooks WHERE id_notebook = ?");
        $borrar->execute([$id_computadora]);
        return $borrar->rowCount(); // devuelve 1 si eliminó algo
    }
}