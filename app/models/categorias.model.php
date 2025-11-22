<?php
class categoriasModel{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=db_asus;charset=utf8', 'root','');
    }

    function mostrarCategorias(){
        $query = $this->db->prepare("SELECT * FROM categorias");
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    function mostrarCategoriasPorId($id){
        $query = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $query->execute();
        $categorias = $query->fetch(PDO::FETCH_OBJ);
        return $categorias;
    }

    function agregarCategorias($categoria,$descripcion) {
        $agregar = $this->db->prepare("INSERT INTO categorias (nombre,descripcion) VALUES (?,?)");
        $agregar->execute([$categoria,$descripcion]);
        return $this->db->lastInsertId(PDO::FETCH_OBJ);
    }

    function actualizarCategoria($categoria,$descripcion,$id) {
    $actualizar = $this->db->prepare("UPDATE categorias SET nombre = ?,descripcion = ? WHERE id = ?");
    $actualizar->execute([$categoria,$descripcion,$id]);    
    }
    
    function obtenerCategoriaPorId($id) {
    $query = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_OBJ);
    }

    function obtenerComputadorasPorCategoria($id) {
    $query = $this->db->prepare("SELECT * FROM notebooks WHERE categoria_id = ?");
    $query->execute([$id]);
    return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerComputadorasPorCategoriaOrdenado($categoria_id, $order) {
    $query = $this->db->prepare("SELECT * FROM notebooks WHERE categoria_id = ? ORDER BY precio $order");
    $query->execute([$categoria_id]);
    return $query->fetchAll(PDO::FETCH_OBJ);
}

    function borrarCategoria($id){
        $query = $this->db->prepare("DELETE FROM categorias WHERE id = ?");
        $query->execute([$id]);
    }
}
?>