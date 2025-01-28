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
        Schema::create('esemenies', function (Blueprint $table) {
            $table->id('esemeny_id');
            $table->string('esemeny_neve');
            $table->text('leiras');
            $table->date('datum');
            $table->text('helyszin');
            $table->integer('letszam');
            $table->timestamps();
        });
        
        DB::table('esemenies')->insert([
            'esemeny_neve' => 'Föld napja',
            'leiras' => 'A Föld napja mára a legnagyobb önszerveződő környezeti megmozdulássá vált Magyarországon. Cselekvő ünnep, amely mindnyájunk jövőjéről szól. Kb. 5 évünk maradt a cselekvésre. 2025-ben újra fókuszban a műanyagok a 35. magyar és az 55. világméretű Föld napján. A mindent uraló műanyagok is veszélyeztetik létünk alapját, az élővilág változatosságát, a biológiai sokféleséget. Mit tehetsz Te? Sokat. Építs közösséget, zöldítsd környezetedet, ültess fát, termelj haszonnövényeket, komposztálj, éheztesd a kukát, szigetelj, közlekedj közösen....',
            'datum' => "2025-04-22",
            'helyszin' => 'Világ területe',
            'letszam' => 1000000
        ]);

                
        DB::table('esemenies')->insert([
            'esemeny_neve' => 'Víz világnapja',
            'leiras' => 'A vízfelhasználás kétszer gyorsabb ütemben nőtt az elmúlt száz évben, mint a Föld népessége. A Föld vízkészlete ugyanakkor állandó, ám az összes víz mindössze 1%-a alkalmas emberi fogyasztásra. A Föld édesvízkészletét nemcsak a túlzott fogyasztás, hanem az éghajlatváltozás, a környezet-szennyezés, a talaj- és vízszennyezés, a gazdasági növekedés, a változó életstílus is veszélyezteti. Már fogytán a tiszta ivóvíz. Mérjük vízhasználatunkat, hogy ésszerűen tudjunk takarékoskodni vele...',
            'datum' => "2025-03-22",
            'helyszin' => 'Világ területe',
            'letszam' => 1000000
        ]);
              
        
        DB::table('esemenies')->insert([
            'esemeny_neve' => 'Óceánok világnapja',
            'leiras' => 'Leginkább a globális felmelegedés, a műanyagszemét és a túlhalászat, túlhasználat fenyegeti a tengereket, óceánokat is. 2008 óta egyre több országban próbálják felhívni a figyelmet az óceánok védelmére. Ez évente 8-9 millió tonna műanyag, amiből a tengeráramlások óriási méretű szemétszigeteket hordanak össze - a legnagyobbat a Csendes-óceán északi térségében, amelynek kiterjedése tizenötszöröse Magyarország területének. A szemét 80%-át a szárazföldről hordják a folyók, a szél a vízbe, és 20% jut közvetlenül a hajókról a tengerekbe. Az óceánok algái (fitoplanktonok) állítják elő a földi oxigén felét és elnyelik a szén-dioxid egynegyedét, szerepük rendkívül fontos az élővilág, az emberiség számára. A klímaváltozás, a víz hőmérsékletének emelkedése azonban fölboríthatja ezt a sérülékeny egyensúlyt. Ennek biztos jele, hogy a korallzátonyok 70%-a már kifehéredett, elpusztult, mert a 30 foknál melegebb vízhőmérsékletet csak nagyon rövid ideig tudják elviselni.',
            'datum' => "2025-06-08",
            'helyszin' => 'Világ területe',
            'letszam' => 1000000
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esemenies');
    }
};
