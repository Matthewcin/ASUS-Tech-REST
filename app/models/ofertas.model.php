<?php 
class ofertasModel {
    protected $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_asus;charset=utf8', 'root','');
    }

    public function obtenerOfertas() {
        $obtener = $this->db->prepare("SELECT * FROM ofertas");
        $obtener->execute([]);
        return $obtener->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerOfertasId($id) {
        $obtenerId = $this->db->prepare("SELECT * FROM ofertas WHERE id = ?");
        $obtenerId->execute([$id]);
        return $obtenerId->fetch(PDO::FETCH_OBJ);
    }

    public function crearOferta($titulo, $descripcion, $fecha_inicio, $fecha_fin, $img) {
        $crear = $this->db->prepare("INSERT INTO ofertas (titulo,descripcion,fecha_inicio,fecha_fin,img) VALUES (?,?,?,?,?)");
        $crear->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $img]);
        return $this->db->lastInsertId();
    }

    public function actualizarOferta($titulo, $descripcion, $fecha_inicio, $fecha_fin, $img,$id) {
        $actualizar = $this->db->prepare("UPDATE ofertas SET titulo = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?, img = ? WHERE id = ?");
        $actualizar->execute([$titulo,$descripcion,$fecha_inicio,$fecha_fin,$img,$id]);
    }

    public function borrarOferta($id) {
        $borrar = $this->db->prepare("DELETE FROM ofertas WHERE id = ?");
        $borrar->execute([$id]);
    }
}