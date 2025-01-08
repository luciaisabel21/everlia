<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";

// Verifica que el usuario esté autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}

// Variables para los formularios
$nombre = $email = $telefono = $relacion = "";
$nombreErr = $emailErr = $telefonoErr = $relacionErr = "";
$errores = false;

// Procesar formulario de añadir invitado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["añadir_invitado"])) {
    if (!empty($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
    } else {
        $nombreErr = "El nombre es obligatorio";
        $errores = true;
    }

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

    if (!empty($_POST["telefono"])) {
        $telefono = $_POST["telefono"];
        if (!preg_match("/^[0-9]{10}$/", $telefono)) {
            $telefonoErr = "El teléfono debe contener 10 dígitos";
            $errores = true;
        }
    } else {
        $telefonoErr = "El teléfono es obligatorio";
        $errores = true;
    }

    if (!empty($_POST["relacion"])) {
        $relacion = $_POST["relacion"];
    } else {
        $relacionErr = "La relación es obligatoria";
        $errores = true;
    }

    if (!$errores) {
        $invitadoId = uniqid(); // Generar un ID único para el invitado
        try {
            añadirInvitado($_SESSION["usuario_id"], $invitadoId, $nombre, $email, $telefono, $relacion);
            echo "<p>Invitado añadido exitosamente.</p>";
        } catch (Exception $e) {
            echo "<p>Error al añadir invitado: " . $e->getMessage() . "</p>";
        }
    }
}

// Procesar eliminación de invitado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_invitado"])) {
    $invitadoId = $_POST["invitado_id"];
    try {
        eliminarInvitado($invitadoId);
        echo "<p>Invitado eliminado exitosamente.</p>";
    } catch (Exception $e) {
        echo "<p>Error al eliminar invitado: " . $e->getMessage() . "</p>";
    }
}

// Obtener la lista de invitados
$invitados = seleccionarPorCriterio("invitado", ["id" => $_SESSION["usuario_id"]]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Invitados</title>
</head>
<body>
    <h1>Gestionar Invitados</h1>

    <!-- Formulario para añadir invitado -->
    <form method="POST" action="">
        <fieldset>
            <legend>Añadir Invitado</legend>
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
            <?php if (!empty($nombreErr)) echo "<p>$nombreErr</p>"; ?>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (!empty($emailErr)) echo "<p>$emailErr</p>"; ?>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>">
            <?php if (!empty($telefonoErr)) echo "<p>$telefonoErr</p>"; ?>

            <label>Relación:</label>
            <input type="text" name="relacion" value="<?php echo htmlspecialchars($relacion); ?>">
            <?php if (!empty($relacionErr)) echo "<p>$relacionErr</p>"; ?>

            <button type="submit" name="añadir_invitado">Añadir Invitado</button>
        </fieldset>
    </form>

    <!-- Lista de invitados -->
    <h2>Lista de Invitados</h2>
    <ul>
        <?php foreach ($invitados as $invitado): ?>
            <li>
                <?php echo htmlspecialchars($invitado["nombre"]); ?> (<?php echo htmlspecialchars($invitado["relacion"]); ?>)
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="invitado_id" value="<?php echo $invitado["id"]; ?>">
                    <button type="submit" name="eliminar_invitado">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>