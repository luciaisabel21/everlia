<?php

class ListaBoda {
	private String $id;
	private Usuario $usuarioId;
	private String $nombreLista;
	private DateTime $fechaCreacion;
	private $regalos = [];
	private $invitados = [];

	public function __construct($id, $usuarioId, $nombreLista, $fechaCreacion) {
    	$this->id = $id;
    	$this->usuarioId = $usuarioId;
    	$this->nombreLista = $nombreLista;
    	$this->fechaCreacion = $fechaCreacion;
	}

    /* revisar si hace falta poner estas funciones tambien en listaBoda, ya que ya las tiene usuario
	public function añadirRegalo($regalo) {
    	$this->regalos[] = $regalo;
	}

	public function añadirInvitado($invitado) {
    	$this->invitados[] = $invitado;
	}

	public function eliminarInvitado($invitado) {
    	$this->invitados = array_filter($this->invitados, function($i) use ($invitado) {
        	return $i !== $invitado;
    	});
	}
}
    */
}

?>