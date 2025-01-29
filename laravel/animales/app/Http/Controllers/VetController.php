<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use Illuminate\Http\Request;

class VetController extends Controller
{

    public function mostrar(){
        return "hola :)";
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vets = Vet::all(); //Pido al modelo todos los Vets
        return view('vet.index', compact('vets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Validar los datos:
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|numeric']);
            
        //Guardar en la base de datos
        Vet::create($request->all());
        //Ir a la vista index con un mensaje de exito
        return redirect()->route('vet.index')->with("success", "Vet creado con exito");
    }

    /**
     * Display the specified resource.
     */
    public function show(Vet $vet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vet $vet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vet $vet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vet $vet)
    {
        //
    }
}