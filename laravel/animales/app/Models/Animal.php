<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //
    protected $fillable = ['name', 'weight', 'age', 'description'];

    //private Vet $vet; //en laravel no se hace asi, se hace con una funcion:

    public function vet() {
        return $this->belongsTo(Vet::class);
    }

    //Animal va a ser el proietario de la relación 1 a 1 con owner
    public function owner() {
        return $this->hasOne(Owner::class);
}
}