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
        Schema::create('cikks', function (Blueprint $table) {
            $table->id('cikk_id');
            $table->varchar('cim',60) ->unique();
            $table->varchar('kepek',255);
            $table->text('leiras');
            $table->date('publikalva')->default('2025.01.07');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cikks');
    }
};
