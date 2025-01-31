<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('phone')->nullable();

            //hacemos la relacion con la tabla Animal, y despues de esto habria que hacer las funciones de relacion(una funcion en Animal, que va a ser hasOne(uno a uno) ya
            //que va a ser como el "padre", y en Owner otra funcion que va a heredar de esa,que va a ser belongsTo)
            $table->foreignId('animal_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
