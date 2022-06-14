<?php
    
    var_dump($_POST);

    $username = $_POST['username'];
    $password = $_POST['password']; 

    try {
        $conexion = new PDO('mysql:host=localhost;dbname=administracion_usuarios', 'root', '');
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }

  $sql = "SELECT tipo_user, username, password FROM usuarios WHERE (username = ?)";
  $sth = $conexion->prepare($sql);
  $sth->bindParam(1, $username, PDO::PARAM_STR);

  if(!$sth->execute()){
    echo "Error al ejecutar la consulta";
    exit;
  }else{
     $sth->execute();

    /* $count=$sth->rowCount(); 
     echo $count;*/

     foreach ($sth as $fila) {

      if (password_verify($_POST['password'] , $fila['password'])) {
         echo "<br/>Inicio de sesion realizado con exito";

         if ($fila['tipo_user'] == "Profesor") {
          echo "<br/>El usuario es un profesor";
         }else {
          echo "<br/>El usuario es un Administrativo";
         }

      }else{
        echo "Credenciales invalidas";
      }

     }
  }

?>