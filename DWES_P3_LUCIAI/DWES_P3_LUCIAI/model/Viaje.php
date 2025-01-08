<?php
class Viaje extends Venta {
	private String $destino;
	private DateTime $fechaDisponible;

	public function __construct($id, $precio, $descripcion, $destino, $fechaDisponible) {
    	parent::__construct($id, $precio, $descripcion);
    	$this->destino = $destino;
    	$this->fechaDisponible = $fechaDisponible;
	}

	public function actualizarPrecio($nuevoPrecio) {
    	$this->precio = $nuevoPrecio;
	}
}
?>
