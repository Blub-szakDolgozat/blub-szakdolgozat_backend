<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akvaria', function (Blueprint $table) {
            $table->unsignedBigInteger('felhasznalo_id'); 
            $table->unsignedBigInteger('vizi_leny_id'); 
            $table->timestamp('bekerules_ideje'); 

            // Összetett kulcs létrehozása
            $table->primary(['felhasznalo_id', 'vizi_leny_id']);

            // Külső kulcsok definiálása
            $table->foreign('felhasznalo_id')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('vizi_leny_id')->references('vizi_leny_id')->on('vizilenyeks')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akvaria');
    }
};
