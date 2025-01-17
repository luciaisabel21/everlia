<?php
session_start();

// viajes
$productos = [
    ["id" => 1, "imagen" => "./imagenes/BALI.jpeg", "descripcion" => "7 días en Bali(Indonesia)", "precio" => 700, "destino" => "BALI"],
    ["id" => 2, "imagen" => "./imagenes/ISLANDIA.jpg", "descripcion" => "9 días en Islandia", "precio" => 1200, "destino" => "ISLANDIA"],
    ["id" => 3, "imagen" => "./imagenes/REPUBLICADOMINICANA.jpg", "descripcion" => "5 días en República Dominicana", "precio" => 900, "destino" => "REPÚBLICA DOMINICANA"],
    ["id" => 4, "imagen" => "./imagenes/croacia.jpg", "descripcion" => "4 días en Croacia", "precio" => 400, "destino" => "CROACIA"],
    ["id" => 5, "imagen" => "./imagenes/egipto.jpg", "descripcion" => "Producto 5 - 10 días en Egipto", "precio" => 1800, "destino" => "EGIPTO"],
    ["id" => 6, "imagen" => "./imagenes/laponia.jpg", "descripcion" => "6 días en Laponia", "precio" => 1000, "destino" => "LAPONIA"],
    ["id" => 7, "imagen" => "./imagenes/maldivas.jpg", "descripcion" => "15 días en Maldivas", "precio" => 2500, "destino" => "MALDIVAS"],
    ["id" => 8, "imagen" => "./imagenes/tanzania.jpg", "descripcion" => "12 días en Tanzania", "precio" => 1900, "destino" => "TANZANIA"],
    ["id" => 9, "imagen" => "./imagenes/dubai.webp", "descripcion" => "5 días en Dubai", "precio" => 1010, "destino" => "DUBAI"],
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
