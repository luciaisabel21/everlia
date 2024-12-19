<?php

abstract class Persona {
	private String $id;
	private $nombre;
	private $email;
	private $telefono;
    private String $contraseña;

    function __construct($id, $nombre, $email, $telefono, $contraseña) {
    	$this->id = $id;
    	$this->nombre = $nombre;
    	$this->email = $email;
    	$this->telefono = $telefono;
        $this->contraseña = $contraseña;
	}

	abstract public function registrarse();
	abstract public function iniciarSesion();
}



?>