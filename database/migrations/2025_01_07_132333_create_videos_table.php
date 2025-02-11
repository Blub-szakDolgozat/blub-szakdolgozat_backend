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
        Schema::create('videos', function (Blueprint $table) {
            $table->id('video_id');
            $table->string('cim')->unique();
            $table->string('nyitokep',255);
            $table->string('link', 255);
            $table->integer('hossz');
            $table->timestamps();
        });

        DB::table('videos')->insert([
            'cim' => 'Hogyan tarthatjuk távol a műanyagokat az óceánoktól? (angol nyelvű)',
            'link' => 'https://www.youtube.com/watch?v=HQTUWK7CM-Y',
            'hossz' => 190,
            'nyitokep' => 'kepek/video1.jpg',
        ]);

        
        DB::table('videos')->insert([
            'cim' => 'Miért kell megállítani a műanyagszennyezést az óceánjainkban? (angol nyelvű)',
            'link' => 'https://www.youtube.com/watch?v=Yomf5pBN8dY',
            'hossz' => 261,
            'nyitokep' => 'kepek/video2.jpg',
        ]);
                
        DB::table('videos')->insert([
            'cim' => 'Kik szennyezik műanyaggal az óceánokat? (angol nyelvű)',
            'link' => 'https://www.youtube.com/watch?v=uRE_DndxwaA',
            'hossz' => 977,
            'nyitokep' => 'kepek/video3.jpg',
        ]);
                        
        DB::table('videos')->insert([
            'cim' => 'Műanyag: áldás és átok (magyar nyelvű)',
            'link' => 'https://www.youtube.com/watch?v=lsyx9TixReg',
            'hossz' => 494,
            'nyitokep' => 'kepek/video4.jpg',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
