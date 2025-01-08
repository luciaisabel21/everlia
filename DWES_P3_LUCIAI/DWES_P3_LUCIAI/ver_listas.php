<?php
ob_start();
session_start();

// Verificar si el usuario tiene la sesión iniciada y es de tipo "invitado"
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "invitado") {
    header("Location: index.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesClases.php";

// Obtener todas las listas de bodas
$listas = obtenerTodasLasListas();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Listas</title>
</head>
<body>
    <h1>Listas de Bodas</h1>
    <ul>
        <?php foreach ($listas as $lista): ?>
            <li>
                <?php echo htmlspecialchars($lista["nombre_lista"]); ?>
                <a href="ver_regalos.php?lista_id=<?php echo $lista["id"]; ?>">Ver Regalos</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php ob_end_flush(); ?>