<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

crearTablaPersona();
crearTablaUsuario();
crearTablaInvitado();
// Inicializar variables
$id = $nombre = $email = $telefono = $pass = $pass2 = $genero = "";
$IdErr = $nombreErr = $emailErr = $telefonoErr = $passErr = $pass2Err = $generoErr = "";
$errores = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Validación de id
     if (!empty($_POST["id"])) {
        $id = $_POST["id"];
    } else {
        $idErr = "El id es obligatorio";
        $errores = true;
    }


    // Validación de nombre
    if (!empty($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
    } else {
        $nombreErr = "El nombre es obligatorio";
        $errores = true;
    }

    // Validación de email
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "El formato del email no es válido";
            $errores = true;
        }
    } else {
        $emailErr = "El email es obligatorio";
        $errores = true;
    }

    // Validación de teléfono
    if (!empty($_POST["telefono"])) {
        $telefono = $_POST["telefono"];
        if (!preg_match("/^[0-9]{9}$/", $telefono)) {
            $telefonoErr = "El teléfono debe contener 9 dígitos";
            $errores = true;
        }
    } else {
        $telefonoErr = "El teléfono es obligatorio";
        $errores = true;
    }

    // Validación de contraseña
    if (!empty($_POST["pass"])) {
        $pass = $_POST["pass"];
    } else {
        $passErr = "La contraseña es obligatoria";
        $errores = true;
    }

    // Validación de repetir contraseña
    if (!empty($_POST["pass2"])) {
        $pass2 = $_POST["pass2"];
        if ($pass !== $pass2) {
            $pass2Err = "Las contraseñas no coinciden";
            $errores = true;
        }
    } else {
        $pass2Err = "Debe repetir la contraseña";
        $errores = true;
    }

    // Validación de género
    if (!empty($_POST["genero"])) {
        $genero = $_POST["genero"];
    } else {
        $generoErr = "Debe seleccionar un género";
        $errores = true;
    }

    // Si no hay errores, registrar al usuario
    if (!$errores) {
        if (registrarUsuario($id, $nombre, $email, $telefono, $pass, $genero)) {
            echo "<p>Registro exitoso. Bienvenido, $nombre.</p>";
        } else {
            echo "<p>Error al registrar. Inténtalo de nuevo más tarde.</p>";
        }
    }
}
?>

<?php include_once "./views/menu.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="./views/estilo.css">
</head>
<body>
    <div class="contenedor">
        <form method="POST" action="">
            <fieldset>
                <legend>SignUp</legend>

                <!-- ID -->
                <label>Id *: </label>
                <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>"><br>
                <?php if (!empty($idErr)) echo "<label class='error'>$idErr</label>"; ?><br>

                <!-- Nombre -->
                <label>Nombre *: </label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br>
                <?php if (!empty($nombreErr)) echo "<label class='error'>$nombreErr</label>"; ?><br>

                <!-- Email -->
                <label>Email *: </label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>
                <?php if (!empty($emailErr)) echo "<label class='error'>$emailErr</label>"; ?><br>

                <!-- Teléfono -->
                <label>Teléfono *: </label>
                <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>"><br>
                <?php if (!empty($telefonoErr)) echo "<label class='error'>$telefonoErr</label>"; ?><br>

                <!-- Contraseña -->
                <label>Contraseña *: </label>
                <input type="password" name="pass"><br>
                <?php if (!empty($passErr)) echo "<label class='error'>$passErr</label>"; ?><br>

                <!-- Repetir contraseña -->
                <label>Repite la contraseña *: </label>
                <input type="password" name="pass2"><br>
                <?php if (!empty($pass2Err)) echo "<label class='error'>$pass2Err</label>"; ?><br>

                <!-- Género -->
                <label>Género *:</label><br>
                <input type="radio" name="genero" value="Masculino" <?php if ($genero == "Masculino") echo "checked"; ?>>Masculino<br>
                <input type="radio" name="genero" value="Femenino" <?php if ($genero == "Femenino") echo "checked"; ?>>Femenino<br>
                <input type="radio" name="genero" value="Otro" <?php if ($genero == "Otro") echo "checked"; ?>>Otro<br>
                <?php if (!empty($generoErr)) echo "<label class='error'>$generoErr</label>"; ?><br>

        
                <input type="submit" name="enviar" value="Registrarse">
            </fieldset>
        </form>
    </div>
</body>
</html>
<?php include_once "./views/pie.php"; ?>