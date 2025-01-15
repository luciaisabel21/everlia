<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesBD.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/database/funcionesClases.php";
// Inserción de usuario con contraseña hasheada


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



function iniciarSesion($email, $contraseña)
{
    $c = conectar();

    // Obtener los datos del usuario
    $sql = $c->prepare("SELECT id, contraseña FROM persona WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario['id']; // Retorna el ID del usuario si las credenciales son correctas
        } else {
            return false; // Contraseña incorrecta
        }
    } else {
        return false; // Usuario no encontrado
    }

    $c->close();
}


//funciones invitados

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

//FUNCIONES LISTA BODA
// Inserta una nueva lista de bodas para el usuario.
function crearListaBoda($usuarioId, $nombreLista) {
    $datos = [
        'id' => uniqid(), // Generar un ID único para la lista
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

//Elimina una lista de bodas.
function eliminarListaBoda($listaId) {
    return eliminarElemento('lista_boda', $listaId);
}
//funciones REGALOS en lista

//añado regalos a la lista
function añadirRegaloALista($listaId, $regaloId, $nombre, $descripcion, $precio, $urlProducto)
{
    $c = conectar();

    $sql = $c->prepare("INSERT INTO regalo (id, lista_boda_id, nombre, descripcion, precio, url_producto) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssds", $regaloId, $listaId, $nombre, $descripcion, $precio, $urlProducto);
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

?>