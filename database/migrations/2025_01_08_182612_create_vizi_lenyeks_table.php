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
        DB::table('vizilenyeks')->insert([
            'nev' => 'Alpesi cápa',
            'fajta' => 'Szárazföldi Cápa',
            'ritkasagi_szint' => '⭐⭐⭐⭐⭐',
            'leiras' => 'Egy nagyon ritka cápa faj, ami csak az alpesi hegyekben fordul elő.',
            'kep' => 'kepek/capaca.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('vizilenyeks')->insert([
            'nev' => 'Leopárdfóka',
            'fajta' => 'Fóka',
            'ritkasagi_szint' => '⭐⭐',
            'leiras' => '. A "leopárdfóka" név inkább az állat foltos, leopárd-szerű mintázatára utal. Ezek a fóka fajták a Föld különböző partjain élnek, és egyre inkább elterjedtek a tengeri élőhelyeken.',
            'kep' => 'kepek/foka.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('vizilenyeks')->insert([
            'nev' => 'Garnélarák',
            'fajta' => 'Rák',
            'ritkasagi_szint' => '⭐',
            'leiras' => 'A garnélák rendkívül gyors mozgásúak, és sok faj rendelkezik egy jellegzetes „ugró” képességgel.',
            'kep' => 'kepek/rak.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('vizilenyeks')->insert([
            'nev' => 'Kardhal',
            'fajta' => 'Hal',
            'ritkasagi_szint' => '⭐⭐',
            'leiras' => 'A kardhalak tengeri ragadozók, amelyek a melegebb vizekben élnek, különösen az Atlanti-óceánban, a Földközi-tengerben és az Indiai-óceán területein. A nevüket az orrjukról kapták, amely hosszú és lapos, mint egy kard. Ezt az orrot vadászatkor használják, hogy megöleljék és megöleljék a zsákmányukat, például más halakat.A kardhal kardja nem csupán eszközként működik a vadászat során, hanem egyben segít a nagy sebesség elérésében is. A gyors úszáshoz optimalizált testével, amely karcsú és erőteljes, képes akár 80 km/h sebességgel úszni.',
            'kep' => 'kepek/kardhal.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('vizilenyeks')->insert([
            'nev' => 'Tigriscápa',
            'fajta' => 'cápa',
            'ritkasagi_szint' => '⭐⭐⭐',
            'leiras' => 'A tigriscápa egy lenyűgöző és erőteljes tengeri ragadozó, amely a cápafélék családjába tartozik. A tigriscápa nevét a testén található jellegzetes, sötét csíkos mintázatáról kapta, amely a tigris csíkjaira emlékeztet. A tigriscápa a világ egyik legnagyobb cápafaja, és az óceánok trópusi és mérsékelt vizeiben él.',
            'kep' => 'kepek/tigriscapa.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('vizilenyeks')->insert([
            'nev' => 'Koi Ponty',
            'fajta' => 'Ponyt',
            'ritkasagi_szint' => '⭐',
            'leiras' => 'A koi pontyok szimbolikus jelentőséggel bírnak, különösen Japánban, ahol a kitartás és a hosszú élet szimbólumaként tartják őket.A koi pontyok kedveltek díszhalakként, és különféle tavakban, kertekben találhatók, ahol gazdáik gondoskodnak róluk.',
            'kep' => 'kepek/koi.png',
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
