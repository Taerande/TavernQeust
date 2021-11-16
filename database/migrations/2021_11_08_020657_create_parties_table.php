<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('game_id');
            $table->string('title',100);
            $table->text('description')->nullable();
            $table->string('dungeon');
            $table->string('difficulty');
            $table->string('goal');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('recruit');
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
        Schema::dropIfExists('parties');
    }
}
