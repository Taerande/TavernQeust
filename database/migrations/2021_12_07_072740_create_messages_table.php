<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // $table->integer('sender_id');
            // $table->integer('sent_to_id');
            $table->text('body');
            $table->text('subject');

            // It's better to work with default timestamp names:
            $table->timestamps();

            // `sender_id` field referenced the `id` field of `users` table:
            $table->foreignId('sender_id');

            // Let's add another foreign key on the same table,
            // but this time fot the `sent_to_id` field:
            $table->foreignId('sent_to_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
