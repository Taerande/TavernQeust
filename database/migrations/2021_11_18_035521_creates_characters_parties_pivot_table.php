<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesCharactersPartiesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_party', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->constrained('parties');
            $table->foreignId('character_id')->constrained('characters');
            $table->enum('grade', ['leader', 'officer', 'member'])->default('member');
            $table->enum('status', [1, 0, -1, -2])->default(0);
            $table->string('memo')->nullable();
            $table->timestamps();

            $table->index(['party_id', 'character_id']);
        });
    }
    /*

    grade : 0 - default
            1 - officer
            2 - raid_leader

    status : 0 - default(uncheck)
             1 - approve(check)
            -1 - reject
    /*

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_party');
    }
}
