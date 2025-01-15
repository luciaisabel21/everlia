<?php

session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";

// Verifica que el usuario esté autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'usuario') {
    header("Location: login.php");
    exit();
}


// Obtener el ID de la lista de bodas desde la URL
if (!isset($_GET["lista_id"])) {
    echo "Error: No se proporcionó el ID de la lista de bodas.";
    exit();
}

$listaId = $_GET["lista_id"];
$invitados = obtenerInvitadosPorLista($listaId); // Función para obtener invitados por lista

// Variables para manejar errores y datos del formulario
$nombre = $email = $telefono = $relacion = "";
$nombreErr = $emailErr = $telefonoErr = $relacionErr = "";
$errores = false;

// Manejar formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y procesar la adición de invitados
    if (isset($_POST["nombre"]) && isset($_POST["email"]) && isset($_POST["telefono"]) && isset($_POST["relacion"])) {
        // Validación del nombre
        if (!empty($_POST["nombre"])) {
            $nombre = htmlspecialchars($_POST["nombre"]);
        } else {
            $nombreErr = "El nombre es obligatorio.";
            $errores = true;
        }

        // Validación del email
        if (!empty($_POST["email"])) {
            $email = htmlspecialchars($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "El formato del email no es válido.";
                $errores = true;
            }
        } else {
            $emailErr = "El email es obligatorio.";
            $errores = true;
        }

        // Validación del teléfono
        if (!empty($_POST["telefono"])) {
            $telefono = htmlspecialchars($_POST["telefono"]);
            if (!preg_match("/^[0-9]{9}$/", $telefono)) {
                $telefonoErr = "El teléfono debe contener 9 dígitos.";
                $errores = true;
            }
        } else {
            $telefonoErr = "El teléfono es obligatorio.";
            $errores = true;
        }

        // Validación de la relación
        if (!empty($_POST["relacion"])) {
            $relacion = htmlspecialchars($_POST["relacion"]);
        } else {
            $relacionErr = "La relación es obligatoria.";
            $errores = true;
        }

        // Si no hay errores, añadir el invitado
        if (!$errores) {
            $invitadoId = uniqid(); // Generar un ID único para el invitado
            añadirInvitado($listaId, $invitadoId, $nombre, $email, $telefono, $relacion);
            header("Location: gestionar_invitados.php?lista_id=$listaId");
            exit();
        }
    }

    // Procesar eliminación de invitados
    if (isset($_POST["eliminar_invitado_id"])) {
        $invitadoId = $_POST["eliminar_invitado_id"];
        eliminarInvitado($invitadoId);
        header("Location: gestionar_invitados.php?lista_id=$listaId");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Invitados</title>
</head>
<body>
    <h1>Gestionar Invitados para la Lista</h1>

    <h2>Añadir Invitado</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        <?php if (!empty($nombreErr)) echo "<p class='error'>$nombreErr</p>"; ?>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php if (!empty($emailErr)) echo "<p class='error'>$emailErr</p>"; ?>
        
        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
        <?php if (!empty($telefonoErr)) echo "<p class='error'>$telefonoErr</p>"; ?>
        
        <label>Relación:</label>
        <input type="text" name="relacion" value="<?php echo htmlspecialchars($relacion); ?>" required>
        <?php if (!empty($relacionErr)) echo "<p class='error'>$relacionErr</p>"; ?>
        
        <button type="submit">Añadir Invitado</button>
    </form>

    <h2>Lista de Invitados</h2>
    <ul>
        <?php foreach ($invitados as $invitado): ?>
            <li>
                <?php echo htmlspecialchars($invitado["nombre"]); ?> (<?php echo htmlspecialchars($invitado["relacion"]); ?>)
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="eliminar_invitado_id" value="<?php echo $invitado["id"]; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php 