<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id');
            $table->tinyInteger('status');
            $table->string('dungeon')->nullable();
            $table->string('goal')->nullable();
            $table->text('description')->nullable();
            $table->unsignedDecimal('reward', 12, 0)->nullable();
            $table->timestamps();
        });
    }
    // 1: activated, 0:deactivated

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scans');
    }
}
