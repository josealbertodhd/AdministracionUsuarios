<?php

$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$tipo = $_POST['tipo'];
$username = $_POST['user'];
$password = $_POST['password'];
$programa = $_POST['programa'];
$activo = 0;

echo "Hola";
var_dump($_POST);

try {
    $conexion = new PDO('mysql:host=localhost;dbname=administracion_usuarios', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

$sql = "INSERT INTO usuarios 
(identificacion, nombres, apellidos, email, tipo_user, username, password, programa, activo) 
VALUES
(?, ?, ?, ?, ?, ?, ?, ?, ?)";

$sth = $conexion->prepare($sql);

$sth->bindParam(1, $identificacion, PDO::PARAM_INT);
$sth->bindParam(2, $nombre, PDO::PARAM_STR);
$sth->bindParam(3, $apellidos, PDO::PARAM_STR);
$sth->bindParam(4, $email, PDO::PARAM_STR);
$sth->bindParam(5, $tipo, PDO::PARAM_STR);
$sth->bindParam(6, $username, PDO::PARAM_STR);
$sth->bindParam(7, $password, PDO::PARAM_STR);
$sth->bindParam(8, $programa, PDO::PARAM_STR);
$sth->bindParam(9, $activo, PDO::PARAM_BOOL);

if(!$sth->execute()){
    echo "Error al ejecutar la consulta";
    exit;
}else{
    echo "Datos registrados";
}

echo "todo okey";

?>