<?php
class Usuario extends Persona {
	private String $genero;
	private DateTime $fechaRegistro;
	private $listaBoda = [];
	private $listaViaje = [];
	private $listaProducto = [];

	public function __construct($id, $nombre, $email, $telefono, $contraseña, $genero, $fechaRegistro) {
    	parent::__construct($id, $nombre, $email, $telefono, $contraseña);
    	$this->genero = $genero;
    	$this->fechaRegistro = $fechaRegistro;
	}

	public function registrarse() {
    	
	}

	public function iniciarSesion() {
    	
	}

	public function añadirRegaloALista($lista, $regalo) {
    	if (in_array($lista, $this->listaBoda)) {
        	$lista->añadirRegalo($regalo);
    	}
	}

	public function añadirInvitado($lista, $invitado) {
    	if (in_array($lista, $this->listaBoda)) {
        	$lista->añadirInvitado($invitado);
    	}
	}

	public function eliminarInvitado($lista, $invitado) {
    	if (in_array($lista, $this->listaBoda)) {
        	$lista->eliminarInvitado($invitado);
    	}
	}
}

?>