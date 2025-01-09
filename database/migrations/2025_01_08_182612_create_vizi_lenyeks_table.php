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
        Schema::create('vizilenyeks', function (Blueprint $table) {
            $table->id('vizi_leny_id'); 
            $table->string('nev', 255)->unique();
            $table->string('fajta', 255); 
            $table->string('ritkasagi_szint', 5); 
            $table->text('leiras'); 
            $table->string('kep')->nullable();
            $table->timestamps();
        });
        DB::table('vizilenyeks')->insert([
            'nev' => 'Aranyhal',
            'fajta' => 'kárász',
            'ritkasagi_szint' => '⭐',
            'leiras' => 'A jól ismert aranyhal, kis méretű és színes. Különböző változatai léteznek.',
            'kep' => 'kepek/OIP.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vizilenyeks');
    }
};
