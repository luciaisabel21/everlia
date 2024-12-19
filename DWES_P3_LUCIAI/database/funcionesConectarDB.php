<?php

function conectar()
{
    return new mysqli("127.0.0.1", "root", "Sandia4you", "everlia");
}

function crearTablas() {
    $c = conectar();
    /*TABLA USUARIO*/
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
    id varchar(50),
    nombre varchar(50),
    email varchar(100),
    telefono int,
    contraseña varchar(100),
    genero varchar(10),
    fechaRegistro date)";
    $c->query($sql);
    /*TABLA INVITADO*/
    $sql = "CREATE TABLE IF NOT EXISTS invitado (
    id varchar(50),
    nombre varchar(50),
    email varchar(100),
    telefono int,
    contraseña varchar(100),
    relacion varchar(100),
    fechaInvitacion date)";
    $c->query($sql);
    /* TABLA LISTABODA */
    $sql = "CREATE TABLE IF NOT EXISTS listaBoda (
    id varchar (50),
    /* investigar como poner el id del usuario */
    nombreLista varchar (100),
    fechaCreacion date)";
    $c ->query($sql);
    /* TABLA REGALO */
    $sql = "CREATE TABLE IF NOT EXISTS regalo (
    id varchar (50),
    nombreRegalo varchar (100),
    descripcion varchar (200),
    precio decimal)";
    $c->query($sql);
    /* TABLA producto*/
    $sql = "CREATE TABLE IF NOT EXISTS producto (
    id varchar (50),
    precio decimal,
    descripcion varchar (200),
    nombre varchar (100)
    categoria varchar (100)
    cantidad int)";
    $c->query($sql);
    /*TABLA VIAJE */
    $sql = "CREATE TABLE IF NOT EXISTS viaje (
    id varchar (50),
    precio decimal,
    descripcion varchar (200),
    destino varchar (100),
    fechaDisponible date)";
    $c->query($sql);
    $c ->close();

}




?>