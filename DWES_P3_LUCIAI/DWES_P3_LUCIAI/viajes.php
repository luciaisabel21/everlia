<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";


// Obtener o crear el carrito del usuario
if (!isset($_SESSION["carrito_id"])) {
    $_SESSION["carrito_id"] = crearCarrito($usuarioId);
}
$carritoId = $_SESSION["carrito_id"];

// Obtener viajes de la base de datos
$viajes = seleccionarTodo("viaje"); // Función genérica para obtener todos los viajes

// Procesar la acción de añadir al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["viaje_id"])) {
    $viajeId = $_POST["viaje_id"];
    agregarRegaloAlCarrito($carritoId, $viajeId); // Puedes usar agregarViajeAlCarrito si tienes una función específica
    header("Location: viajes.php"); // Recargar la página para evitar reenvío del formulario
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viajes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Menú dinámico -->
    <?php include_once "./views/menu.php"; ?>
    <div class="container my-5">
        <h1 class="text-center">Viajes Disponibles</h1>
        <div class="row">
            <?php foreach ($viajes as $viaje): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Viaje">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($viaje["destino"]); ?></h5>
                            <p class="card-text"><strong>Fecha disponible:</strong> <?php echo htmlspecialchars($viaje["fecha_disponible"]); ?></p>
                            <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($viaje["precio"]); ?> €</p>
                            <form method="POST">
                                <input type="hidden" name="viaje_id" value="<?php echo $viaje["id"]; ?>">
                                <button type="submit" class="btn btn-primary">Añadir al Carrito</button>
                            </form>
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

<!-- Viajes:

Los viajes se obtienen de la tabla viaje usando seleccionarTodo("viaje").
Cada viaje incluye un destino, una fecha disponible y un precio.
Formulario para añadir al carrito:

Cada tarjeta de viaje tiene un botón que envía el id del viaje al servidor.
El botón usa el método POST para añadir el viaje al carrito.
Redirección después de añadir al carrito:

Después de añadir un viaje, la página se recarga para evitar reenvío del formulario.
Bootstrap:

Utiliza el componente de tarjetas (card) para mostrar los viajes.
Diseño responsivo que se adapta a diferentes tamaños de pantalla.
            -->