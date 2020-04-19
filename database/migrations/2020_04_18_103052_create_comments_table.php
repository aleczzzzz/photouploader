<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('photo_id');
            $table->text('comment');
            $table->timestamps();

            $table->foreign('user_id', 'comment_user_id')->references('id')->on('users');
            $table->foreign('photo_id', 'comment_photo_id')->references('id')->on('photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
