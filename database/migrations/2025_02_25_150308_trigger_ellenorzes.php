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
        DB::unprepared('
            DELIMITER $$

            CREATE TRIGGER check_existing_creature
            BEFORE INSERT ON akvaria
            FOR EACH ROW
            BEGIN
                IF EXISTS (SELECT 1 FROM akvaria WHERE felhasznalo_id = NEW.felhasznalo_id AND vizi_leny_id = NEW.vizi_leny_id) THEN
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "This water creature is already in your aquarium.";
                END IF;
            END $$

            DELIMITER ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS check_existing_creature');
    }
};
