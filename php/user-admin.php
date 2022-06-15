<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'C:\xampp\htdocs\trabajoproyecto\vendor\autoload.php';

$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$tipo = $_POST['tipo'];
$username = $_POST['user'];
$programa = $_POST['programa'];
$activo = 0;

//$salt = "83ijwkkwe339wwkwo39" . $_POST['password']; 
$salt = bin2hex(random_bytes(6));
$password = password_hash($_POST['password'] , PASSWORD_BCRYPT);

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

$hashIni = hash("sha256", $password);

$hashPoli = hash("sha256", $password);

$mail = new PHPMailer();


$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_OFF;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->Username = 'towermass.net@gmail.com';
$mail->Password = 'mwzivcjmfffcgohi';
$mail->setFrom('towermass.net@gmail.com', 'Jose Alberto De Hoyos');
$mail->addAddress($email, $nombre);
$mail->Subject = 'Recuperacion de contraseña';
$mensaje = "<h1> Bienvenido a nuestra Plataforma </h1>
            <a href='https://www.youtube.com/'>Haga click en el enlace para acceder a nuestra pagina</a>";
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body ::file_get_contents('contents.html')

$mail->msgHTML($mensaje);
$mail->AltBody = 'This is a plain-text message body';

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}

?>  