<?php

class Invitado extends Persona {
	private $relacion;
	private $fechaInvitacion;

	public function __construct($id, $nombre, $email, $telefono, $contraseña, $relacion, $fechaInvitacion) {
    	parent::__construct($id, $nombre, $email, $telefono, $contraseña);
    	$this->relacion = $relacion;
    	$this->fechaInvitacion = $fechaInvitacion;
	}
  
}


?>