<?php
session_start();

// viajes
$productos = [
    ["id" => 1, "imagen" => "./imagenes/decoracion.jpg", "descripcion" => "7 días en Bali(Indonesia)", "precio" => 700, "destino" => ""],
    ["id" => 2, "imagen" => "./imagenes/decoracionProducto1.jpeg", "descripcion" => "7 días en Islandia", "precio" => 750, "destino" => ""],
    ["id" => 3, "imagen" => "./imagenes/decoracionProducto2.jpg", "descripcion" => "7 días en República Dominicana", "precio" => 800, "destino" => " "],
    ["id" => 4, "imagen" => "./imagenes/vestidoNovia.jpg", "descripcion" => "7 días en Croacia", "precio" => 600, "destino" => "Croacia"],
    ["id" => 5, "imagen" => "./imagenes/vestidoNovia2.jpg", "descripcion" => "7 días en Egipto", "precio" => 850, "destino" => "Egipto"],
    ["id" => 6, "imagen" => "./imagenes/vestidoNovia3.jpg", "descripcion" => "5 días en Laponia", "precio" => 900, "destino" => "Laponia"],
    ["id" => 7, "imagen" => "./imagenes/TrajeHombre1.jpeg", "descripcion" => "7 días en Maldivas", "precio" => 1200, "destino" => "Maldivas"],
    ["id" => 8, "imagen" => "./imagenes/TrajeHombre2.jpeg", "descripcion" => "7 días en Tanzania", "precio" => 1100, "destino" => "Tanzania"],
    ["id" => 9, "imagen" => "./imagenes/TrajeHombre3.jpeg", "descripcion" => "5 días en Dubái", "precio" => 1300, "destino" => "Dubái"],
    ["id" => 10, "imagen" => "./imagenes/ramoFlores.jpg", "descripcion" => "7 días en Sidney", "precio" => 1050, "destino" => "Sidney"],
    ["id" => 11, "imagen" => "./imagenes/ramoFlores1.jpeg", "descripcion" => "5 días en París", "precio" => 700, "destino" => "París"],
    ["id" => 12, "imagen" => "./imagenes/ramoFlores2.jpeg", "descripcion" => "7 días en Tokio", "precio" => 950, "destino" => "Tokio"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["producto_id"]) && isset($_POST["fecha_usuario"])) {
    $productoId = $_POST["producto_id"];
    $fechaUsuario = $_POST["fecha_usuario"];

    // Crear el carrito en la sesión si no existe
    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = [];
    }

    // Añadir el producto al carrito
    $_SESSION["carrito"][] = [
        "producto_id" => $productoId,
        "fecha_usuario" => $fechaUsuario,
    ];

    // Redirigir para evitar reenvíos duplicados
    header("Location: carrito.php");
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
        <h1 class="text-center">Encuentra tu destino soñado</h1>
        <div class="row">
            <?php $contador = 0; ?>
            <?php foreach ($productos as $producto): ?>
                <!-- Iniciar una nueva fila cada 3 productos -->
                <?php if ($contador % 3 == 0): ?>
                    <div class="row mb-4">
                <?php endif; ?>

                <!-- Tarjeta de producto -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($producto['destino']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto["destino"]); ?></h5>
                            <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($producto["descripcion"]); ?></p>
                            <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($producto["precio"]); ?> € /persona</p>
                            <form method="POST">
                                <input type="hidden" name="producto_id" value="<?php echo $producto["id"]; ?>">
                                <label for="fecha_usuario_<?php echo $producto['id']; ?>">Selecciona una fecha:</label>
                                <input type="date" id="fecha_usuario_<?php echo $producto['id']; ?>" name="fecha_usuario" class="form-control mb-2" required>
                                <button type="submit" class="btn btn-primary">Añadir al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cerrar la fila después de 3 productos -->
                <?php if ($contador % 3 == 2): ?>
                    </div>
                <?php endif; ?>

                <?php $contador++; ?>
            <?php endforeach; ?>

            <!-- Cerrar la última fila si tiene menos de 3 productos -->
            <?php if ($contador % 3 != 0): ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include_once "./views/pie.php"; ?>
