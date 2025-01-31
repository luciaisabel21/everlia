<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Owner;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //1. pido al modelo que bisque todos los animales en la BD
        $animales = Animal::all(); 
        //2. Creo una bista con dichos animales
        return view('animal.index', compact ('animales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //aquí suministro una vista con un formulario en blanco de creación
        return view('animal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        //Primeroo tengo que crear el animal
        $animal=Animal::create($request->all());

        //Después tengo que crear el propietario:
        //Opción 1: crear un objeto Owner, meterle en sus atributos los datos del formulario, guardar en la bd
        $owner = new Owner();
        $owner->name = $request->input('ownername');
        $owner->phone = $request->input('ownerphone');
        $owner->animal()->associate($animal);
        $owner->save();
        
        
        //redirijo a la vista de index
        return redirect()->route('animal.index')->with('success', value: 'Animal creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        return view('animal.show', compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal) //el edit te muestra la vista
    {
        return view('animal.edit', compact('animal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal) //el update te actualiza la BD
    //request contiene los datos del formulario
    {
        $animal->update($request->all());
        //reenviamos al index
        return redirect()->route('animal.index')->with('success', 'Animal actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        //para eliminar un registro de la BD
        $animal->delete();
        //reenviamos al index
        return redirect()->route('animal.index')->with('success', 'Animal eliminado con exito');
    }
}
