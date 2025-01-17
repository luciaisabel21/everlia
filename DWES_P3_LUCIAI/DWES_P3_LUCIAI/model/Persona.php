<?php

abstract class Persona {
	private $id;
	private $nombre;
	private $telefono;
    private $tipo;
    private $genero;
    

    function __construct($id, $nombre, $telefono, $tipo, $genero) {
    	$this->id = $id;
    	$this->nombre = $nombre;
    	$this->telefono = $telefono;
        $this->tipo = $tipo;
        $this->genero = $genero;
        
	}


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }


	/**
	 * Get the value of telefono
	 */ 
	public function getTelefono()
	{
		return $this->telefono;
	}

	/**
	 * Set the value of telefono
	 *
	 * @return  self
	 */ 
	public function setTelefono($telefono)
	{
		$this->telefono = $telefono;

		return $this;
	}


    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of genero
     */ 
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set the value of genero
     *
     * @return  self
     */ 
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }
}



?>