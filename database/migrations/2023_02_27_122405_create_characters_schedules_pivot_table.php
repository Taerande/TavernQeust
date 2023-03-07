<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersSchedulesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules');
            $table->foreignId('character_id')->constrained('characters');
            $table->enum('grade', ['leader', 'officer', 'member', 'applicant'])->default('member');
            // 0 => none, 1 => approve, -1 => reject
            $table->tinyInteger('status')->default(0);
            $table->string('spec')->nullable();;
            $table->text('apply')->nullable();
            $table->text('reject')->nullable();
            $table->text('memo')->nullable();
            $table->timestamps();

            $table->index(['schedule_id', 'character_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_schedule');
    }
}
