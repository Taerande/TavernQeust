<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercenariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercenaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters');;
            $table->foreignId('game_id')->constrained('games');;
            $table->string('author');
            $table->char('title', 100);
            $table->text('description')->nullable();
            $table->string('dungeon');
            $table->string('difficulty');
            $table->unsignedDecimal('reward', 12, 0)->nullable();
            $table->tinyInteger('status')->default('1'); // active = 1, inactive = -1 ,pause = 0;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mercenaries');
    }
}
