<?php
//Conexion a la base de datos
$localhost = "localhost";
$db = "jquery";
$user = "root";
$password = "";
try {
    $conexion = new PDO("mysql:host=$localhost; dbname=$db;", $user, $password);
    //echo 'bien';
} catch (Exception $ex) {
    echo $ex->getMessage();
}

//insertar los datos

if (isset($_GET['accion']) == "insertar") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $sentenciaSQL = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio) VALUES(:nombre, :descripcion, :precio);");
    $sentenciaSQL->bindParam(':nombre', $nombre);
    $sentenciaSQL->bindParam(':descripcion', $descripcion);
    $sentenciaSQL->bindParam(':precio', $precio);
    $sentenciaSQL->execute();
    exit();
}

//borrar datos, pero se debe enviar una clave (para el borrado)

if(isset($_GET["borrar"])){

    $id=$_GET["borrar"];
    $sentenciaSQL=$conexion->prepare("DELETE FROM productos WHERE id=:id");
    $sentenciaSQL->bindParam('id:',$id);
    $sentenciaSQL->execute();
    exit();
}

//Consulta de productos
$sentenciaSQL = $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaproductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($listaproductos);
