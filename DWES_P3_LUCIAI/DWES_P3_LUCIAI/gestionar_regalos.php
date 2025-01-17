<?php
session_start();



include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/operacionesUsuario.php";

crearTablaListaBoda();
crearTablaRegalo();


// Verificar que el usuario esté autenticado y sea de tipo "usuario"
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] != "usuario") {
    header("Location: index.php");
    exit();
}


// Obtener el ID de la lista de bodas desde la URL
if (!isset($_GET["lista_id"])) {
    echo "Error: No se proporcionó el ID de la lista de bodas.";
    exit();
}

$listaId = $_GET["lista_id"];
$regalos = obtenerRegalosPorLista($listaId); // Función para obtener regalos por lista

// Variables para manejar errores y datos del formulario
$nombre = $descripcion = $precio = $urlProducto = "";
$nombreErr = $descripcionErr = $precioErr = $urlProductoErr = "";
$errores = false;

// Manejar formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y procesar la adición de regalos
    if (isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["precio"]) && isset($_POST["url_producto"])) {
        // Validación del nombre
        if (!empty($_POST["nombre"])) {
            $nombre = htmlspecialchars($_POST["nombre"]);
        } else {
            $nombreErr = "El nombre del regalo es obligatorio.";
            $errores = true;
        }

        // Validación de la descripción
        if (!empty($_POST["descripcion"])) {
            $descripcion = htmlspecialchars($_POST["descripcion"]);
        } else {
            $descripcionErr = "La descripción es obligatoria.";
            $errores = true;
        }

        // Validación del precio
        if (!empty($_POST["precio"])) {
            $precio = htmlspecialchars($_POST["precio"]);
            if (!is_numeric($precio) || $precio <= 0) {
                $precioErr = "El precio debe ser un número positivo.";
                $errores = true;
            }
        } else {
            $precioErr = "El precio es obligatorio.";
            $errores = true;
        }

        // Validación del enlace del producto
        if (!empty($_POST["url_producto"])) {
            $urlProducto = htmlspecialchars($_POST["url_producto"]);
            if (!filter_var($urlProducto, FILTER_VALIDATE_URL)) {
                $urlProductoErr = "El enlace del producto no es válido.";
                $errores = true;
            }
        } else {
            $urlProductoErr = "El enlace del producto es obligatorio.";
            $errores = true;
        }

        // Si no hay errores, añadir el regalo
        if (!$errores) {
            $regaloId = uniqid(); // Generar un ID único para el regalo
            añadirRegaloALista($listaId, $regaloId, $nombre, $descripcion, $precio, $urlProducto);
            header("Location: gestionar_regalos.php?lista_boda_id=$listaId");
            exit();
        }
    }

    // Procesar eliminación de regalos
    if (isset($_POST["eliminar_regalo_id"])) {
        $regaloId = $_POST["eliminar_regalo_id"];
        eliminarRegaloDeLista($regaloId);
        header("Location: gestionar_regalos.php?lista_boda_id=$listaId");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Regalos</title>
</head>
<body>
    <h1>Gestionar Regalos para la Lista</h1>

    <h2>Añadir Regalo</h2>
    <form method="POST">
        <label>Nombre del regalo:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        <?php if (!empty($nombreErr)) echo "<p class='error'>$nombreErr</p>"; ?>

        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($descripcion); ?></textarea>
        <?php if (!empty($descripcionErr)) echo "<p class='error'>$descripcionErr</p>"; ?>

        <label>Precio:</label>
        <input type="text" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required>
        <?php if (!empty($precioErr)) echo "<p class='error'>$precioErr</p>"; ?>

        <label>Enlace del producto:</label>
        <input type="url" name="url_producto" value="<?php echo htmlspecialchars($urlProducto); ?>" required>
        <?php if (!empty($urlProductoErr)) echo "<p class='error'>$urlProductoErr</p>"; ?>

        <button type="submit">Añadir Regalo</button>
    </form>

    <h2>Lista de Regalos</h2>
    <ul>
        <?php foreach ($regalos as $regalo): ?>
            <li>
                <?php echo htmlspecialchars($regalo["nombre"]); ?> (<?php echo htmlspecialchars($regalo["precio"]); ?> €)
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="eliminar_regalo_id" value="<?php echo $regalo["id"]; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php include_once "./views/pie.php"; ?>
<?php 