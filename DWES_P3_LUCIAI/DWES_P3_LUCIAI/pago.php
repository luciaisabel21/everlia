<?php
session_start();

// Verificar si la compra fue realizada
if (!isset($_SESSION["resumen_compra"])) {
    header("Location: carrito.php");
    exit();
}

$resumen = $_SESSION["resumen_compra"];
$total = $_SESSION["total_compra"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1>Simulación de Pago</h1>

        <h3>Resumen de tu Compra</h3>
        <ul class="list-group">
            <?php foreach ($resumen as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo htmlspecialchars($item["descripcion"]); ?></strong><br>
                        Precio: <?php echo htmlspecialchars($item["precio"]); ?> €<br>
                        Fecha seleccionada: <?php echo htmlspecialchars($item["fecha"]); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="mt-3">
            <h4>Total de la compra: <?php echo htmlspecialchars($total); ?> €</h4>
        </div>

        <h3>Detalles de Pago</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="tarjeta" class="form-label">Número de tarjeta</label>
                <input type="text" class="form-control" id="tarjeta" name="tarjeta" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección de envío</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="alert alert-success mt-3">
                ¡Compra realizada con éxito! Hemos simulado tu pago.
            </div>
            <?php
            // Limpiar la sesión después de "pagar"
            session_unset();
            session_destroy();
            ?>
        <?php endif; ?>
    </div>
</body>

</html>