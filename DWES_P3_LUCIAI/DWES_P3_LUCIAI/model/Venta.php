<?php

abstract class Venta {
	private String $id;
	private  $precio;
	private String $descripcion;

	public function __construct($id, $precio, $descripcion) {
    	$this->id = $id;
    	$this->precio = $precio;
    	$this->descripcion = $descripcion;
	}

	abstract public function actualizarPrecio($nuevoPrecio);


}



?>