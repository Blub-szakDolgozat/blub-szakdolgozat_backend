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
        Schema::create('feliratkozas', function (Blueprint $table) {
            $table->unsignedBigInteger('felhasznalo'); 
            $table->unsignedBigInteger('esemeny'); 
            $table->timestamp('feliratkozas_datuma')->nullable();
            $table->timestamps();  

            $table->primary(['felhasznalo', 'esemeny']);

            // Külső kulcsok definiálása
            $table->foreign('felhasznalo')->references('azonosito')->on('users')->onDelete('cascade');
            $table->foreign('esemeny')->references('esemeny_id')->on('esemenies')->onDelete('cascade');
        });

        DB::table('feliratkozas')->insert([
            'felhasznalo' => 1,
            'esemeny' => 2,
            'feliratkozas_datuma' => "2025-04-22",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feliratkozas');
    }
};
