<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

crearTablaRegalo();
crearTablaVenta();
crearTablaViaje();
crearTablaProducto();
crearTablaCarrito();
crearTablaCarrito_Producto();
crearTablaCarrito_Viaje();


// Verificar que la sesión tiene el ID del usuario
if (!isset($_SESSION["usuario_id"])) {
    die("Error: No hay un usuario autenticado.");
}

$usuarioId = $_SESSION["usuario_id"]; // Inicializar la variable $usuarioId

// Obtener o crear el carrito del usuario
if (!isset($_SESSION["carrito_id"])) {
    $_SESSION["carrito_id"] = crearCarrito($usuarioId);
}
$carritoId = $_SESSION["carrito_id"];

// Procesar acciones del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["regalo_id"])) {
        agregarRegaloAlCarrito($carritoId, $_POST["regalo_id"]);
    } elseif (isset($_POST["finalizar_compra"])) {
        finalizarCompra($carritoId);
        echo "<p>Compra finalizada con éxito.</p>";
    } elseif (isset($_POST["vaciar_carrito"])) {
        vaciarCarrito($carritoId);
    }
}

// Obtener los regalos del carrito
$regalos = obtenerRegalosDelCarrito($carritoId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>
    <ul>
        <?php foreach ($regalos as $regalo): ?>
            <li>
                <?php echo htmlspecialchars($regalo["nombre"]); ?> (<?php echo htmlspecialchars($regalo["precio"]); ?> €)
            </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST">
        <button type="submit" name="finalizar_compra">Finalizar Compra</button>
        <button type="submit" name="vaciar_carrito">Vaciar Carrito</button>
    </form>
</body>
</html>