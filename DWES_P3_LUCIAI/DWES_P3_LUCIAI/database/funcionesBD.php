<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Persona.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Usuario.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Invitado.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/ListaBoda.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Regalo.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Venta.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Producto.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Viaje.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/DWES_P3_LUCIAI/model/Carrito.php";

function conectar(){
    $server = "127.0.0.1";
    $user = "root";
    $password = "Sandia4you";
    $db = "everlia";

    $conexion = new mysqli($server, $user, $password, $db);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    return $conexion;
}

function crearTablaPersona() {
    $c = conectar();

    // TABLA PERSONA
    $sql = "CREATE TABLE IF NOT EXISTS persona (
        id INT AUTO_INCREMENT PRIMARY KEY,  
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(115),
        password_hash VARCHAR(255) NOT NULL, 
        tipo ENUM('usuario', 'invitado') NOT NULL
        
    )";

    if (!$c->query($sql)) {
        die("Error al crear tabla persona: " . $c->error);
    }
}

    function crearTablaUsuario() {
        $c = conectar();

    // TABLA USUARIO
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
        id INT AUTO_INCREMENT PRIMARY KEY,
        telefono VARCHAR(20),
        genero ENUM('Masculino', 'Femenino', 'Otro'),
        FOREIGN KEY (id) REFERENCES persona(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla usuario: " . $c->error);
    }
}
function crearTablaInvitado() {
    $c = conectar();

    // TABLA INVITADO
    $sql = "CREATE TABLE IF NOT EXISTS invitado (
        id INT AUTO_INCREMENT PRIMARY KEY,
        relacion VARCHAR(50),
        FOREIGN KEY (id) REFERENCES persona(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla invitado: " . $c->error);
    }

    }

    function crearTablaListaBoda() {
        $c = conectar();
    // TABLA LISTA BODA
    $sql = "CREATE TABLE IF NOT EXISTS lista_boda (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        nombre_lista VARCHAR(100),
        fecha_creacion DATETIME,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla lista_boda: " . $c->error);
    }
    }
    function crearTablaRegalo() {
        $c = conectar();

    // TABLA REGALO
    $sql = "CREATE TABLE IF NOT EXISTS regalo (
        id INT AUTO_INCREMENT PRIMARY KEY,
        lista_boda_id INT NOT NULL,
        nombre VARCHAR(100),
        descripcion TEXT,
        precio DECIMAL(10, 2),
        url_producto VARCHAR(1024),
        comprado BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (lista_boda_id) REFERENCES lista_boda(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla regalo: " . $c->error);
    }

    }
    function crearTablaVenta() {
        $c = conectar();
    // TABLA VENTA
    $sql = "CREATE TABLE IF NOT EXISTS venta (
        id INT AUTO_INCREMENT PRIMARY KEY,
        precio DECIMAL(10, 2),
        descripcion TEXT
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla venta: " . $c->error);
    }
    }
    function crearTablaViaje() {
        $c = conectar();

    // TABLA VIAJE
    $sql = "CREATE TABLE IF NOT EXISTS viaje (
        id INT AUTO_INCREMENT PRIMARY KEY,
        destino VARCHAR(100),
        fecha_disponible DATETIME,
        FOREIGN KEY (id) REFERENCES venta(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla viaje: " . $c->error);
    }
    }
    function crearTablaProducto() {
        $c = conectar();

    // TABLA PRODUCTO
    $sql = "CREATE TABLE IF NOT EXISTS producto (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100),
        cantidad INT,
        FOREIGN KEY (id) REFERENCES venta(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla producto: " . $c->error);
    }
    }
    function crearTablaCarrito() {
        $c = conectar();

    // TABLA CARRITO
    $sql = "CREATE TABLE IF NOT EXISTS carrito (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuario(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla carrito: " . $c->error);
    }
    }
    function crearTablaCarrito_Producto() {
        $c = conectar();

    // TABLA CARRITO_PRODUCTO
    $sql = "CREATE TABLE IF NOT EXISTS carrito_producto (
        carrito_id INT NOT NULL,
        producto_id INT NOT NULL,
        cantidad INT,
        PRIMARY KEY (carrito_id, producto_id),
        FOREIGN KEY (carrito_id) REFERENCES carrito(id),
        FOREIGN KEY (producto_id) REFERENCES producto(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla carrito_producto: " . $c->error);
    }
    }
    function crearTablaCarrito_Viaje() {
        $c = conectar();

    // TABLA CARRITO_VIAJE
    $sql = "CREATE TABLE IF NOT EXISTS carrito_viaje (
        carrito_id INT NOT NULL,
        viaje_id INT NOT NULL,
        PRIMARY KEY (carrito_id, viaje_id),
        FOREIGN KEY (carrito_id) REFERENCES carrito(id),
        FOREIGN KEY (viaje_id) REFERENCES viaje(id)
    )";
    if (!$c->query($sql)) {
        die("Error al crear tabla carrito_viaje: " . $c->error);
    }

    $c->close();
}


function registrarUsuario($id, $nombre, $email, $telefono, $pass, $genero) {
    $conexion = conectar();

    // Hash de la contraseña
    $password_hash = password_hash($pass, PASSWORD_DEFAULT);

    // Insertar en la tabla persona
    $sqlPersona = "INSERT INTO persona (id, nombre, email, password_hash) VALUES (?, ?, ?, ?)";
    $stmtPersona = $conexion->prepare($sqlPersona);
    $stmtPersona->bind_param("isss", $id, $nombre, $email, $password_hash);
    $stmtPersona->execute();

    // Obtener el ID generado para persona
    $idPersona = $conexion->insert_id;

    // Insertar en la tabla usuario
    $sqlUsuario = "INSERT INTO usuario (id, telefono, genero) VALUES (?, ?, ?)";
    $stmtUsuario = $conexion->prepare($sqlUsuario);
    $stmtUsuario->bind_param("iss", $idPersona, $telefono, $genero);
    $stmtUsuario->execute();


    // Cerrar las declaraciones
    $stmtPersona->close();
    $stmtUsuario->close();

    $conexion->close();

    return true;
}
?>