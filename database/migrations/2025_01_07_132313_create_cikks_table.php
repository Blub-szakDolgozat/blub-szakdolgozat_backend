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
        Schema::create('cikks', function (Blueprint $table) {
            $table->id('cikk_id');
            $table->string('cim',60) ->unique();
            $table->string('kepek',255);
            $table->text('leiras');
            $table->date('publikalva')->default('2025-01-07');
            $table->timestamps();
        });
        DB::table('cikks')->insert([
            'cim' => 'Az óceánok szemétproblémája és megoldások',
            'kepek' => 'kepek/cikk1.jpg',
            'leiras' => 'Az óceánok az élet forrásai és az egész bolygónk számára elengedhetetlenek. Azonban sajnos az óceánok napról napra egyre inkább veszélyeztetettek a szemét és a szennyezés miatt. Az óceánokba naponta millió tonna műanyag hulladék és szemét kerül, ami súlyos környezeti problémákat okoz. Ez a cikk arról fog szólni, hogy miért van szükségünk az óceánok védelmére, és hogyan segíthetünk az óceánok megtisztításában és megőrzésében.',
            'publikalva' => '2025-06-08',
        ]);
   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cikks');
    }
};
