<?php

class Carrito {
	private Usuario $usuarioId;
	private $productos = [];
	private $viajes = [];

	public function __construct($usuarioId) {
    	$this->usuarioId = $usuarioId;
	}

	public function añadirProducto($producto) {
    	$this->productos[] = $producto;
	}

	public function eliminarProducto($producto) {
    	$this->productos = array_filter($this->productos, function($p) use ($producto) {
        	return $p !== $producto;
    	});
	}

	public function añadirViaje($viaje) {
    	$this->viajes[] = $viaje;
	}

	public function eliminarViaje($viaje) {
    	$this->viajes = array_filter($this->viajes, function($v) use ($viaje) {
        	return $v !== $viaje;
    	});
	}

	public function obtenerTotal() {
    	$total = 0;
    	foreach ($this->productos as $producto) {
        	$total += $producto->precio;
    	}
    	foreach ($this->viajes as $viaje) {
        	$total += $viaje->precio;
    	}
    	return $total;
	}
}



?>