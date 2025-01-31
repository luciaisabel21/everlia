<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address']; //aquí da igual el orden

    //En laravel no se hace así, aunque el resultado será similar:
    //private $animals;

    //Propiedad o atributo dinámico: a la clase vet le creo un atributo llamado animals que será un array de objetos de la clase Animal
    public function animals () {
        return $this->hasMany('Animal::class');
        
    }
}
