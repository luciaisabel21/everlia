<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";

// Variables para guardar los valores introducidos
$email = $pass = $rol ="";
$emailErr = $passErr = $rolErr = "";
$errores = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación del email
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

    // Validación de la contraseña
    if (!empty($_POST["pass"])) {
        $pass = $_POST["pass"];
    } else {
        $passErr = "La contraseña es obligatoria";
        $errores = true;
    }

    // Validación del rol
    if (!empty($_POST["rol"])) {
        $rol = $_POST["rol"];
    } else {
        $rolErr = "Debe seleccionar un rol";
        $errores = true;
    }

    // Si no hay errores, realizar la autenticación
    if (!$errores) {
        // Llamar a la función para autenticar al usuario
        $persona = autenticarPersona($email, $pass, $rol);

        if ($persona) {
            // Si la autenticación funciona, almacenar los datos en la sesión
            $_SESSION["usuario_id"] = $persona["id"];
            $_SESSION["usuario_nombre"] = $persona["nombre"];
            $_SESSION["usuario_email"] = $persona["email"];
            $_SESSION["usuario_tipo"] = $persona["tipo"]; // usuario o invitado

            // Redirigir según el tipo de usuario
            if ($persona["tipo"] == "usuario") {
                header("Location: index.php");
            } else if ($persona["tipo"] == "invitado") {
                header("Location: index.php");
            }
            exit();
        } else {
            $passErr = "Email o contraseña incorrectos o rol no coincide.";
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
    <title>Iniciar Sesión</title>
</head>
<body>
    <form method="POST" action="">
        <fieldset>
            <legend>Iniciar Sesión</legend>
            <!-- Email -->
            <label>Email *: </label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="<?php echo empty($emailErr) ? "" : "err"; ?>"><br>
            <?php if (!empty($emailErr)) {
                echo "<label class='error'>$emailErr</label>";
            } ?>
            <br>

            <!-- Contraseña -->
            <label>Contraseña *: </label>
            <input type="password" name="pass" class="<?php echo empty($passErr) ? "" : "err"; ?>"><br>
            <?php if (!empty($passErr)) {
                echo "<label class='error'>$passErr</label>";
            } ?>
            <br>

            <!-- Selección de rol -->
            <label>Iniciar sesión como:</label><br>
            <input type="radio" name="rol" value="usuario" <?php echo (isset($_POST["rol"]) && $_POST["rol"] == "usuario") ? "checked" : ""; ?>> Usuario<br>
            <input type="radio" name="rol" value="invitado" <?php echo (isset($_POST["rol"]) && $_POST["rol"] == "invitado") ? "checked" : ""; ?>> Invitado<br>
            <?php if (!empty($rolErr)) {
                echo "<label class='error'>$rolErr</label>";
            } ?>
            <br>

            <input type="submit" name="enviar" value="Iniciar Sesión">
        </fieldset>
    </form>
</body>
</html>
<?php include_once "./views/pie.php"; ?>
