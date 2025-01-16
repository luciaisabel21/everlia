
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";

/* Inserción: un elemento o varios */
function insertarElemento($tabla, $datos)
{
    $conexion = conectar();
    $columnas = implode(", ", array_keys($datos));
    $valores = implode(", ", array_map(function ($item) use ($conexion) {
        return "'" . $conexion->real_escape_string($item) . "'";
    }, array_values($datos)));

    $sql = "INSERT INTO $tabla ($columnas) VALUES ($valores)";
    return $conexion->query($sql);
}

/* Lectura: seleccionar todo */
function seleccionarTodo($tabla)
{
    $conexion = conectar();
    $sql = "SELECT * FROM $tabla";
    $resultado = $conexion->query($sql);

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    return $datos;
}

/* Lectura: seleccionar por criterio */
function seleccionarPorCriterio($tabla, $criterio)
{
    $conexion = conectar();
    $condiciones = [];
    foreach ($criterio as $columna => $valor) {
        $condiciones[] = "$columna = '" . $conexion->real_escape_string($valor) . "'";
    }

    $where = implode(" AND ", $condiciones);
    $sql = "SELECT * FROM $tabla WHERE $where";
    $resultado = $conexion->query($sql);

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    return $datos;
}

/* Modificación: un elemento */
function modificarElemento($tabla, $id, $datos)
{
    $conexion = conectar();
    $updates = [];
    foreach ($datos as $columna => $valor) {
        $updates[] = "$columna = '" . $conexion->real_escape_string($valor) . "'";
    }

    $set = implode(", ", $updates);
    $sql = "UPDATE $tabla SET $set WHERE id = '" . $conexion->real_escape_string($id) . "'";
    return $conexion->query($sql);
}

/* Eliminación: un elemento */
function eliminarElemento($tabla, $id)
{
    $conexion = conectar();
    $sql = "DELETE FROM $tabla WHERE id = '" . $conexion->real_escape_string($id) . "'";
    return $conexion->query($sql);
}


?>