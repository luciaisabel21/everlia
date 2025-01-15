<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
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

    /*Lo de abajo: Consulta el campo tipo en la tabla persona.
Guarda el tipo en la sesión ($_SESSION["usuario_tipo"]).
Redirige al usuario según su tipo:
Los usuarios van a la página para gestionar su lista de bodas.
Los invitados van a la página para ver las listas y comprar regalos. */
if (!$errores) {
    $conexion = conectar();

    // Consultar el tipo en la tabla persona
    $sql = "SELECT id, nombre, email, password_hash, tipo FROM persona WHERE email = ? AND tipo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $email, $rol); // Filtrar también por el tipo (usuario/invitado)
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $persona = $resultado->fetch_assoc();
        if (password_verify($pass, $persona["password_hash"])) {
            // Guardar los datos en la sesión
            $_SESSION["usuario_id"] = $persona["id"];
            $_SESSION["usuario_nombre"] = $persona["nombre"];
            $_SESSION["usuario_email"] = $persona["email"];
            $_SESSION["usuario_tipo"] = $persona["tipo"]; // 'usuario' o 'invitado'

            // Redirigir según el tipo de usuario
            if ($persona["tipo"] == "usuario") {
                header("Location: gestionar_listas.php"); // Redirigir a la página de lista de bodas
            } else if ($persona["tipo"] == "invitado") {
                header("Location: ver_listas.php"); // Redirigir a la vista de listas
            }
            exit();
        } else {
            $passErr = "Email o contraseña incorrectos.";
        }
    } else {
        $passErr = "Email o contraseña incorrectos o rol no coincide.";
    }

    $stmt->close();
    $conexion->close();
    
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