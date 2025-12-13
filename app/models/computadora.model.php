<?php

class ComputadoraModel {
    protected $db;

    function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=db_asus;charset=utf8', 'root','');
    }

    function obtenerComputadoras() {
        $query = $this->db->prepare("SELECT * FROM notebooks");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function obtenerComputadorasID($id) {
        $query = $this->db->prepare("SELECT * FROM notebooks WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function agregarComputadoras($modelo,$descripcion,$precio,$categoria_id,$imagen) {
    $agregar = $this->db->prepare("INSERT INTO notebooks (modelo,descripcion,precio,categoria_id,img) VALUES (?,?,?,?,?)");
    $agregar->execute([$modelo,$descripcion,$precio,$categoria_id,$imagen]);
    return $this->db->lastInsertId();
    }

    function eliminarComputadorax($id) {
        $eliminar = $this->db->prepare("DELETE FROM notebooks WHERE id = ?");
        $eliminar->execute([$id]);
    }

    function actualizarComputadorax($id, $modelo, $descripcion, $precio, $categoria_id, $img) {
    $actualizar = $this->db->prepare("UPDATE notebooks SET modelo = ?, descripcion = ?, precio = ?, categoria_id = ?, img = ? WHERE id = ?");
    $actualizar->execute([$modelo, $descripcion, $precio, $categoria_id, $img, $id]);
    }

   public function ordenarComputadoras($categoria_id, $orderBy, $order, $limit) { // ARREGLADO
    $query = $this->db->prepare("SELECT * FROM notebooks");
    $params = [];

    // Aca filtro por Categorias
    if ($categoria_id != null) {
        $query .= " WHERE categoria_id = ?";
        $params[] = $categoria_id;
    }

    // Ordeno
    $query .= " ORDER BY $orderBy $order";

    // Aca Limito
    if ($limit != null) {
        $query .= " LIMIT $limit";
    }

    $query = $this->db->prepare($query); // dependiendo lo que usó el usuario ejecuto los parametros utilizados
    $query->execute($params);
    return $query->fetchAll(PDO::FETCH_OBJ);
}

    function paginarProductos($limit){
        if(!is_numeric($limit)) return false; // SI EL LIMIT NO ES UN NUMERO ENTONCES NO HACER NADA

        $query = $this->db->prepare("SELECT * FROM notebooks LIMIT $limit");
        $query->execute();
        $productos = $query->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

}
