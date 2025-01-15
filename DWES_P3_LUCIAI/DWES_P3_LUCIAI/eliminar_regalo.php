<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";


// Verificar que el usuario ha iniciado sesion
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: index.php");
    exit();
}
    
// Verificar que se reciban los parámetros necesarios
if (!isset($_GET["regalo_id"]) || !isset($_GET["lista_id"])) {
    header("Location: gestionar_listas.php");
    exit();
}

$regaloId = $_GET["regalo_id"];
$listaId = $_GET["lista_id"];

try {
    eliminarRegaloDeLista($regaloId);
    header("Location: gestionar_regalos.php?lista_id=$listaId");
    exit();
} catch (Exception $e) {
    echo "<p>Error al eliminar regalo: " . $e->getMessage() . "</p>";
}
?>