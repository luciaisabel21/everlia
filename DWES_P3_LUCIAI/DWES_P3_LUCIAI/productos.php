<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";

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

// Obtener productos (regalos) de la base de datos
$productos = seleccionarTodo("regalo"); // Función genérica para obtener todos los regalos

// Procesar la acción de añadir al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"])) {
    $productoId = $_POST["producto_id"];
    agregarRegaloAlCarrito($carritoId, $productoId);
    header("Location: productos.php"); // Recargar la página para evitar reenvío del formulario
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Menú dinámico -->
    <?php include_once "./views/menu.php"; ?>
    <div class="container my-5">
        <h1 class="text-center">Productos Disponibles</h1>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Producto">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto["nombre"]); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($producto["descripcion"]); ?></p>
                            <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($producto["precio"]); ?> €</p>
                            <?php if ($producto["comprado"]): ?>
                                <button class="btn btn-success" disabled>Comprado</button>
                            <?php else: ?>
                                <form method="POST">
                                    <input type="hidden" name="producto_id" value="<?php echo $producto["id"]; ?>">
                                    <button type="submit" class="btn btn-primary">Añadir al Carrito</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Pie de página -->
<?php include_once "./views/pie.php"; ?>
</body>
</html>
<!--
Productos:

Se obtienen de la base de datos usando seleccionarTodo("regalo").
Cada producto se muestra como una tarjeta de Bootstrap.
Formulario para añadir al carrito:

Cada tarjeta tiene un botón que envía el id del producto al servidor.
Si el producto ya está comprado (comprado = 1), el botón se desactiva.
Redirección después de añadir al carrito:

Después de añadir un producto, la página se recarga para evitar reenvío del formulario.
Bootstrap:

Utiliza un diseño de tarjetas (card) para mostrar los productos.
El diseño es responsivo y se adapta a diferentes tamaños de pantalla. -->