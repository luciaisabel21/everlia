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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("name");
            $table->float("weight");
            $table->integer("age");
            $table->text("description");
            $table->foreignId('vet_id')->nullable()->constrained();//relacionamos la tabla animal con la clave primaria de vet
            //el constrined es como si pusieras todo lo que poniamos en las consultas de foreign key..., nullable es que puede ser null,
            // y lo ponemos en este caso porque la relacion que queremos hacer es n:0, es decir, un animal no tiene por qué tener un veterinario,
            //por eso ponemos nullable, porque puede ser null(cero)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
