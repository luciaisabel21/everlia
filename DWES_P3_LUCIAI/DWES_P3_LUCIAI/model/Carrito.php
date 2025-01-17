<?php

class Carrito {
	private Usuario $usuarioId;
	private $productos = [];
	private $viajes = [];

	public function __construct($usuarioId) {
    	$this->usuarioId = $usuarioId;
	}

	
}



?>