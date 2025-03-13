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
        DB::table('cikks')->insert([
            'cim' => 'Melegedő óceánok, árvizek és aszályok',
            'kepek' => 'kepek/cikk2.jpeg',
            'leiras' => 'Európát is érinti az éghajlatváltozás, és a hatások nem csak szárazföldön érezhetők. A jelenség az európai víztestekre, vagyis a tavakra, folyókra, valamint a kontinens körüli óceánokra és tengerekre is kihat.
            Az európai tengerpartok mentén a tengerfelszín hőmérséklete gyorsabb növekedést mutat, mint a világóceánok. A vízhőmérséklet a tengeri élővilág egyik legerősebb szabályozó tényezője, és a hőmérséklet emelkedése máris nagy változásokat idéz elő a víz alatt, beleértve a tengeri fajok eloszlásának jelentős átrendeződését, az Éghajlatváltozás, hatások és kiszolgáltatottság Európában 2016-ban című EEA jelentés megállapításai szerint.
            A főleg a Csendes-óceán és az Indiai-óceán melegebb vize miatt bekövetkezett drámai mértékű korallfehéredés felhívta a figyelmet az „óceáni hőhullámok” által a helyi tengeri ökoszisztémákra gyakorolt hatásokra. Bármelyik fontos elemnek, például a víz hőmérsékletének, sótartalmának vagy oxigénszintjének apró változása is kedvezőtlen hatással lehet ezekre az érzékeny ökoszisztémákra.
            Az éghajlatváltozás egyik kulcselemét a Föld vízkörforgására gyakorolt hatás jelenti; e körforgás végzi a víz folyamatos elosztását az óceánokból a légkörbe, szárazföldre, folyókba és tavakba, majd vissza a tengerekbe és az óceánokba.',
            'publikalva' => '2025-03-13',
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
