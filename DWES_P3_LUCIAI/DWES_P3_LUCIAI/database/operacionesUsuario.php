<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesClases.php";
// Inserción de usuario con contraseña hasheada

/*
function insertarUsuario($id, $nombre, $email, $telefono, $pass, $genero, $fecha)
{
    $c = conectar();

    // Hashear la contraseña
    $contraseñaHasheada = password_hash($pass, PASSWORD_BCRYPT);

    // Insertar en la tabla persona

    
    $sql = $c->prepare("INSERT INTO persona (id, nombre, email, telefono, pass) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssis", $id, $nombre, $email, $telefono, $contraseñaHasheada);
    if (!$sql->execute()) {
        die("Error al insertar en persona: " . $c->error);
    }

    // Insertar en la tabla usuario
    $sql = $c->prepare("INSERT INTO usuario (id, genero, fecha_registro) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $id, $genero, $fecha);
    if (!$sql->execute()) {
        die("Error al insertar en usuario: " . $c->error);
    }

    $c->close();
}
// Lectura de usuario por ID
function obtenerUsuarioPorId($id)
{
    $c = conectar();

    $sql = $c->prepare("SELECT p.id, p.nombre, p.email, p.telefono, u.genero, u.fecha_registro 
                         FROM persona p 
                         JOIN usuario u ON p.id = u.id 
                         WHERE p.id = ?");
    $sql->bind_param("s", $id);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_assoc(); // Devuelve los datos del usuario como un array asociativo
    } else {
        return null; // Usuario no encontrado
    }

    $c->close();
}

*/

function autenticarPersona($email, $pass, $rol) {
    $conexion = conectar();

    // Consulta para verificar usuario y rol
    $sql = "SELECT id, nombre, email, password_hash, tipo FROM persona WHERE email = ? AND tipo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $email, $rol); 
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $persona = $resultado->fetch_assoc();
        if (password_verify($pass, $persona["password_hash"])) {
            // Datos correctos, devolver información del usuario
            return $persona;
        } else {
            // Contraseña incorrecta
            return false;
        }
    } else {
        // No se encontró el usuario o el rol no coincide
        return false;
    }

    $stmt->close();
    $conexion->close();
}

/*
//FUNCIONES INVITADOS ##########################################################

function añadirInvitado($listaId, $invitadoId, $nombre, $email, $telefono, $relacion)
{
    $c = conectar();

    // Insertar en la tabla persona
    $sqlPersona = $c->prepare("INSERT INTO persona (id, nombre, email, telefono) VALUES (?, ?, ?, ?)");
    $sqlPersona->bind_param("ssis", $invitadoId, $nombre, $email, $telefono);
    $sqlPersona->execute();

    // Insertar en la tabla invitado
    $sqlInvitado = $c->prepare("INSERT INTO invitado (id, relacion, fecha_invitacion) VALUES (?, ?, NOW())");
    $sqlInvitado->bind_param("ss", $invitadoId, $relacion);
    $sqlInvitado->execute();

    $c->close();
}

function eliminarInvitado($invitadoId)
{
    $c = conectar();

    // Eliminar de la tabla invitado
    $sqlInvitado = $c->prepare("DELETE FROM invitado WHERE id = ?");
    $sqlInvitado->bind_param("s", $invitadoId);
    $sqlInvitado->execute();

    // Eliminar de la tabla persona
    $sqlPersona = $c->prepare("DELETE FROM persona WHERE id = ?");
    $sqlPersona->bind_param("s", $invitadoId);
    $sqlPersona->execute();

    $c->close();
}

function obtenerInvitadosPorLista($listaId) {
    $c = conectar();

    $sql = $c->prepare("SELECT p.id, p.nombre, p.email, i.relacion 
                        FROM persona p 
                        JOIN invitado i ON p.id = i.id 
                        WHERE i.lista_id = ?");
    $sql->bind_param("s", $listaId);
    $sql->execute();
    $resultado = $sql->get_result();

    $invitados = [];
    while ($fila = $resultado->fetch_assoc()) {
        $invitados[] = $fila;
    }

    $c->close();
    return $invitados;
}

*/

//FUNCIONES LISTA BODA#################################################################



// Inserta una nueva lista de bodas para el usuario.
//SI SE UTILIZA
function crearListaBoda($usuarioId, $nombreLista) {
    $datos = [
        'usuario_id' => $usuarioId,
        'nombre_lista' => $nombreLista,
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];
    return insertarElemento('lista_boda', $datos);
}

// Devuelve todas las listas de bodas de un usuario 
function obtenerListasPorUsuario($usuarioId) {
    return seleccionarPorCriterio('lista_boda', ['usuario_id' => $usuarioId]);
}

//Actualizar el nombre de una lista de bodas
//SI SE UTILIZA
function modificarListaBoda($listaId, $nuevoNombre) {
    $c = conectar();

    $sql = $c->prepare("UPDATE lista_boda SET nombre_lista = ? WHERE id = ?");
    $sql->bind_param("ss", $nuevoNombre, $listaId);

    if ($sql->execute()) {
        $sql->close();
        $c->close();
        return true;
    } else {
        $sql->close();
        $c->close();
        return false;
    }
}

// Devuelve todas las listas de bodas disponibles en la base de datos.
function obtenerTodasLasListas() {
    return seleccionarTodo('lista_boda');
}

//SI SE UTILIZA
//Elimina una lista de bodas.
function eliminarListaBoda($listaId) {
    return eliminarElemento('lista_boda', $listaId);
}
//REGALOS FUNCIONES ##########################################################

//añado regalos a la lista
function añadirRegaloALista($listaId, $regaloId, $nombre, $descripcion, $precio, $urlProducto)
{
    $c = conectar();

    $sql = $c->prepare("INSERT INTO regalo (lista_boda_id, nombre, descripcion, precio, url_producto) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("issss", $listaId, $nombre, $descripcion, $precio, $urlProducto);
    $sql->execute();

    $c->close();
}
//Devuelve todos los regalos asociados a una lista de bodas.
function obtenerRegalosPorLista($listaId) {
    return seleccionarPorCriterio('regalo', ['lista_boda_id' => $listaId]);
}

//Elimina un regalo específico de una lista.
function eliminarRegaloDeLista($regaloId) {
    return eliminarElemento('regalo', $regaloId);
}
//Actualiza el campo comprado de un regalo para indicar que ha sido adquirido.
function marcarRegaloComoComprado($regaloId) {
    return modificarElemento('regalo', $regaloId, ['comprado' => true]);
}



//CARRITO FUNCIONES ####################################################

function crearCarrito($usuarioId) {
    $c = conectar();

    $sql = $c->prepare("INSERT INTO carrito (usuario_id) VALUES (?)");
    $sql->bind_param("s", $usuarioId);
    $sql->execute();

    // Recupera el ID del carrito recién creado
    $carritoId = $c->insert_id;
    $c->close();
    return $carritoId; // Retorna el ID generado automáticamente
}

function agregarRegaloAlCarrito($carritoId, $regaloId) {
    $c = conectar();

    $sql = $c->prepare("INSERT INTO carrito_producto (carrito_id, producto_id, cantidad) VALUES (?, ?, 1)");
    $sql->bind_param("ss", $carritoId, $regaloId);
    $sql->execute();

    $c->close();
}

function obtenerRegalosDelCarrito($carritoId) {
    $c = conectar();

    $sql = $c->prepare("SELECT r.id, r.nombre, r.descripcion, r.precio 
                        FROM carrito_producto cp
                        JOIN regalo r ON cp.producto_id = r.id
                        WHERE cp.carrito_id = ?");
    $sql->bind_param("s", $carritoId);
    $sql->execute();
    $resultado = $sql->get_result();

    $regalos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $regalos[] = $fila;
    }

    $c->close();
    return $regalos;
}

function finalizarCompra($carritoId) {
    $c = conectar();

    // Obtener los regalos del carrito
    $regalos = obtenerRegalosDelCarrito($carritoId);

    // Marcar cada regalo como comprado
    foreach ($regalos as $regalo) {
        $sql = $c->prepare("UPDATE regalo SET comprado = 1 WHERE id = ?");
        $sql->bind_param("s", $regalo["id"]);
        $sql->execute();
    }

    // Vaciar el carrito
    $sql = $c->prepare("DELETE FROM carrito_producto WHERE carrito_id = ?");
    $sql->bind_param("s", $carritoId);
    $sql->execute();

    $c->close();
}

function vaciarCarrito($carritoId) {
    $c = conectar();

    $sql = $c->prepare("DELETE FROM carrito_producto WHERE carrito_id = ?");
    $sql->bind_param("s", $carritoId);
    $sql->execute();

    $c->close();
}

?>