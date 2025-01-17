<?php
session_start();

// Simular productos (deberían coincidir con los de productos.php)
$productos = [
    ["id" => 1, "imagen" => "./imagenes/BALI.jpeg", "descripcion" => "7 días en Bali(Indonesia)", "precio" => 700, "destino" => "BALI"],
    ["id" => 2, "imagen" => "./imagenes/ISLANDIA.jpg", "descripcion" => "Producto 2 - Una descripción breve", "precio" => 25, "destino" => "Destino 2"],
    ["id" => 3, "imagen" => "./imagenes/REPUBLICADOMINICANA.jpg", "descripcion" => "Producto 3 - Una descripción breve", "precio" => 30, "destino" => "Destino 3"],
    ["id" => 4, "imagen" => "./imagenes/croacia.jpg", "descripcion" => "Producto 4 - Una descripción breve", "precio" => 35, "destino" => "Destino 4"],
    ["id" => 5, "imagen" => "./imagenes/egipto.jpg", "descripcion" => "Producto 5 - Una descripción breve", "precio" => 40, "destino" => "Destino 5"],
    ["id" => 6, "imagen" => "./imagenes/laponia.jpg", "descripcion" => "Producto 6 - Una descripción breve", "precio" => 45, "destino" => "Destino 6"],
    ["id" => 7, "imagen" => "./imagenes/maldivas.jpg", "descripcion" => "Producto 7 - Una descripción breve", "precio" => 50, "destino" => "Destino 7"],
    ["id" => 8, "imagen" => "./imagenes/tanzania.jpg", "descripcion" => "Producto 8 - Una descripción breve", "precio" => 55, "destino" => "Destino 8"],
    ["id" => 9, "imagen" => "./imagenes/dubai.webp", "descripcion" => "Producto 9 - Una descripción breve", "precio" => 60, "destino" => "Destino 9"],
];


// Verificar si hay productos en el carrito
$carrito = $_SESSION["carrito"] ?? [];

// Calcular el total de la compra
$total = 0;
foreach ($carrito as $item) {
    $producto = $productos[$item["producto_id"]];
    $total += $producto["precio"];
}

// Procesar acciones del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["finalizar_compra"])) {
        // Mostrar el resumen de la compra
        $resumen = [];
        foreach ($carrito as $item) {
            $producto = $productos[$item["producto_id"]];
            $resumen[] = [
                "descripcion" => $producto["descripcion"],
                "precio" => $producto["precio"],
                "fecha" => $item["fecha_usuario"]
            ];
        }
        $_SESSION["carrito"] = []; // Vaciar el carrito después de la compra

        // Redirigir a la pantalla de pago
        $_SESSION["resumen_compra"] = $resumen;
        $_SESSION["total_compra"] = $total;
        header("Location: pago.php");
        exit();
    } elseif (isset($_POST["vaciar_carrito"])) {
        $_SESSION["carrito"] = []; // Vaciar el carrito
    }

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
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1>Carrito de Compras</h1>
        <?php if (empty($carrito)): ?>
            <p>No hay productos en el carrito.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($carrito as $item): ?>
                    <?php $producto = $productos[$item["producto_id"]]; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($producto["descripcion"]); ?></strong><br>
                            Precio: <?php echo htmlspecialchars($producto["precio"]); ?> €<br>
                            Fecha seleccionada: <?php echo htmlspecialchars($item["fecha_usuario"]); ?>
                        </div>
                        <img src="<?php echo htmlspecialchars($producto["imagen"]); ?>" alt="Imagen del producto" style="width: 100px;">
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Resumen del Total -->
            <div class="mt-3">
                <h4>Total de la compra: <?php echo htmlspecialchars($total); ?> €</h4>
            </div>

            <form method="POST" class="mt-3">
                <button type="submit" name="finalizar_compra" class="btn btn-success">Finalizar Compra</button>
                <button type="submit" name="vaciar_carrito" class="btn btn-danger">Vaciar Carrito</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>