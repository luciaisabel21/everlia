<?php
ob_start();
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
crearTablaListaBoda();

//esto comprueba que la sesion este inicida y ya te deja acceder al resto,
//si no está iniciada no te deja

if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: index.php");
    exit();
}


include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";
$usuarioId = $_SESSION["usuario_id"];

$listas = obtenerListasPorUsuario($usuarioId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre_lista"])) {
        crearListaBoda($usuarioId, $_POST["nombre_lista"]);
    } elseif (isset($_POST["modificar_lista_id"])) {
        modificarListaBoda($_POST["modificar_lista_id"], $_POST["nuevo_nombre"]);
    } elseif (isset($_POST["eliminar_lista_id"])) {
        eliminarListaBoda($_POST["eliminar_lista_id"]);
    }
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
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="modificar_lista_id" value="<?php echo $lista["id"]; ?>">
                    <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre" required>
                    <button type="submit">Modificar</button>
                </form>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="eliminar_lista_id" value="<?php echo $lista["id"]; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php ob_end_flush(); ?>