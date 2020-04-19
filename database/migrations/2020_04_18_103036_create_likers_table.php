<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('photo_id');
            $table->timestamps();

            $table->foreign('user_id', 'liker_user_id')->references('id')->on('users');
            $table->foreign('photo_id', 'liker_photo_id')->references('id')->on('photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likers');
    }
}
