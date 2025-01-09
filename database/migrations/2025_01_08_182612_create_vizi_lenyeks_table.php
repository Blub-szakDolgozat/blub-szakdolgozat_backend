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
        Schema::create('vizi_lenyeks', function (Blueprint $table) {
            $table->id('vizi_leny_id'); 
            $table->string('nev', 255)->unique(); 
            $table->string('ritkasagi_szint', 5); 
            $table->text('leiras'); 
            $table->binary('kep');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vizi_lenyeks');
    }
};
