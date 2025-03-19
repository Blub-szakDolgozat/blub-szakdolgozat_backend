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
        DB::table('cikks')->insert([
            'cim' => 'Telítődnek az óceánok a műanyaggal',
            'kepek' => 'kepek/cikk3.jpg',
            'leiras' => 'Évente nyolcmillió tonna műanyag kerül a tengerekbe. A szennyezés visszafordíthatatlan károkat okozhat az óceánok élővilágában - figyelmeztet az ENSZ Környezetvédelmi Programja (UNEP).
            Az óceánok kritikus helyzete az egyik fő téma az ENSZ Nairobiban zajló, háromnapos környezetvédelmi konferenciáján (UNEA) is. A tanácskozáson az ENSZ szakosított szervezete arra szólította fel az országok kormányait és a magánszektort, hogy mérsékeljék a műanyagból készült termékek gyártását. "A gyökerénél kell kezelni a problémát" - mondta Erik Solheim, az UNEP igazgatója.
            Egyre több tengerparttal rendelkező ország ismeri fel a problémát és dönt az egyszer használható műanyag zacskók betiltása mellett, mint legutóbb Kenya is tette. Indonézia - ahol Kína után a világon a  legtöbb műanyagot gyártják - vállalta, hogy 2025-ig 75 százalékkal csökkenti az óceánba kerülő műanyag mennyiségét. Környezetvédelmi szervezetek szerint azonban mindez kevés: az ENSZ-nek menetrendet kell felállítania a tengerek műanyagszennyezésének teljes felszámolására. ',
            'publikalva' => '2017-12-05',
        ]);
        DB::table('cikks')->insert([
            'cim' => 'Egyre sürgetőbb az óceánok védelme!',
            'kepek' => 'kepek/cikk4.jpg',
            'leiras' => '2018 és 2022 között 8,5 százalékkal, csaknem 8,5 millió órára nőtt a halászati tevékenységgel töltött idő az óceánok nyílt vizein - derült ki a Greenpeace új jelentéséből, amely az óceánokat fenyegető veszélyekről készült.
            „A tendenciák tehát azt mutatják, hogy a valóságban pont az ellenkezője történik, mint amit az óceánvédelmi egyezményben meghatároztak” - figyelmeztetnek a jelentésben, amely részletesen ismerteti azt is, hogy az óceánok felmelegedése, elsavasodása, szennyezése egyre nagyobb terhet ró a tenger élővilágára.
            A jelentés szerint jelenleg a nyílt tengerek kevesebb mint 1 százalékát védik megfelelően, és ahhoz, hogy 2030-ra a világ óceánjainak 30 százaléka védett legyen, évente körülbelül 11 millió négyzetkilométernyi tengeri területet kell megóvni a pusztítástól.
            Az ökológiai jelentőségük alapján a Greenpeace három nyílt tengeri területet javasol elsőként védetté nyilvánítani: a Csendes-óceán északnyugati részén található Emperor-fenékhegyvidéket, a Sargasso-tengert és az Ausztrália és Új-Zéland közötti Lord Howe-hátságot.',
            'publikalva' => '2023-08-04',
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
