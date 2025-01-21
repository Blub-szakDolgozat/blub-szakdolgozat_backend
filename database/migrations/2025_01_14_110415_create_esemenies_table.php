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
        Schema::create('esemenies', function (Blueprint $table) {
            $table->id('esemeny_id');
            $table->string('esemeny_neve');
            $table->text('leiras');
            $table->date('datum');
            $table->text('helyszin');
            $table->integer('letszam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esemenies');
    }
};
