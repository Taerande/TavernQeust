<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->nullable();
            $table->foreignId('mercenary_id')->nullable();
            $table->string('dungeon');
            $table->text('title');
            $table->string('difficulty');
            $table->text('description')->nullable();
            $table->string('goal')->nullable();
            $table->string('recruit');
            // active = 1, inactive = -1 ,pause = 0;
            $table->tinyInteger('status')->default(1);
            $table->unsignedDecimal('reward', 12, 0)->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
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
        Schema::dropIfExists('schedules');
    }
}
