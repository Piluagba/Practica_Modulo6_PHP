<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Formulario de Registro</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        
    </head>
    <body>
        <div class="group">
        

            <form method="POST" action="">
            <h2><em>Formulario de Registro</em></h2>

        <label for="Nombre">Nombre<span><em>(requerido)</em></span></label><br>
        <input type="text" name="Nombre" class="form-input" required/>
        
        <br>

        <label for="Apellido">Apellido<span><em>(requerido)</em></span></label><br>
        <input type="text" name="Apellido" class="form-input" required/>
        
        <br>

        <label for="Email">Email<span><em>(requerido)</em></span></label><br>
        <input type="Email" name="Email" class="form-input" required/>
        
        <br>
        <input class="form-btn" name="submit" type="submit" value="Suscribirse"/>

<?php

function validarEmail($Email) {
    $pattern = '/^[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/';
    return preg_match($pattern, $Email);
}

function validarNombreApellido($cadena) {
    $pattern = '/^[A-Za-z]+$/';
    return preg_match($pattern, $cadena);
}

if($_POST) {
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Email = $_POST['Email'];
    
//Validación campos vacíos 
if (empty($Nombre) || empty($Apellido) || empty($Email)) {
    echo "Necesario completar todos los campos.";
    return;
}

//Validación campo nombre y apellido no números
if (!validarNombreApellido($Nombre) || !validarNombreApellido($Apellido)) {
    echo "El nombre y el apellido solo pueden contener letras.";
    return;
}

//Validación correo electrónico
if (!filter_var ($Email, FILTER_VALIDATE_EMAIL)){
    echo "Ingrese un email válido.";
    return;
}


//conexion con PDO

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "modulosql";

//Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error){
    die("connection failed:". $conn->connection_error);
}

// Verificar si el correo electrónico ya está registrado
$sql = "SELECT * FROM usuario WHERE Email = '$Email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "El correo electrónico ya está registrado.";
    $conn->close();
    return;
}

//Insertar usuario

$sql = "INSERT INTO usuario (Nombre, Apellido, Email) VALUES ('$Nombre', '$Apellido', '$Email')";

if ($conn->query($sql) === TRUE){
    echo "Usuario registrado correctamente";
} else{ 
    echo "Error:" . $sql . "<br>" . $conn->error;
}

$conn-> close();
}

?>

            </form>
        </div>
    </body>
</html>

