<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('channel_id');
            // $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('best_reply_id')->nullable();
            // $table->foreign('best_reply_id')->references('id')->on('replies');
            $table->integer('count_view')->default('0');
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
        Schema::dropIfExists('threads');
    }
}
