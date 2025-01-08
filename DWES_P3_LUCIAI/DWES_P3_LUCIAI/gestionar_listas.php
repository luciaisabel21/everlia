<?php
ob_start();
session_start();

// Verificar si el usuario tiene la sesión iniciada y es de tipo "usuario"
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: index.php");
    exit();
}

include_once "./DWES_P3_LUCIAI/database/operacionesUsuario.php";

$usuarioId = $_SESSION["usuario_id"];
$listas = obtenerListasPorUsuario($usuarioId);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_lista"])) {
    crearListaBoda($usuarioId, $_POST["nombre_lista"]);
    header("Location: gestionar_listas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Listas</title>
</head>
<body>
    <h1>Mis Listas de Bodas</h1>
    <form method="POST">
        <label>Nombre de la lista:</label>
        <input type="text" name="nombre_lista" required>
        <button type="submit">Crear Lista</button>
    </form>
    <ul>
        <?php foreach ($listas as $lista): ?>
            <li>
                <?php echo htmlspecialchars($lista["nombre_lista"]); ?>
                <a href="gestionar_regalos.php?lista_id=<?php echo $lista["id"]; ?>">Gestionar Regalos</a>
                <a href="eliminar_lista.php?lista_id=<?php echo $lista["id"]; ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php ob_end_flush(); ?>