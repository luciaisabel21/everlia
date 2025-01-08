<?php

class Producto extends Venta {
	private $nombre;
	private $categoria;
	private $cantidad;

	public function __construct($id, $precio, $descripcion, $nombre, $categoria, $cantidad) {
    	parent::__construct($id, $precio, $descripcion);
    	$this->nombre = $nombre;
    	$this->categoria = $categoria;
    	$this->cantidad = $cantidad;
	}

	public function actualizarPrecio($nuevoPrecio) {
    	$this->precio = $nuevoPrecio;
	}

	public function actualizarCantidad($nuevaCantidad) {
    	$this->cantidad = $nuevaCantidad;
	}
}



?>