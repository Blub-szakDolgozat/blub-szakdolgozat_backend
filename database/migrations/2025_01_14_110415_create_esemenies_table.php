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
            $table->id('esemény_id');
            $table->string('esemény_neve');
            $table->text('leírás');
            $table->date('dátum');
            $table->text('helyszín');
            $table->integer('létszám');
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
