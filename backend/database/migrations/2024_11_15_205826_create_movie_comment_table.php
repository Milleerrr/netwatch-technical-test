<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieCommentTable extends Migration
{
    public function up()
    {
        Schema::create('movie_comment', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('comment_id');

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');

            $table->primary(['movie_id', 'comment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_comment');
    }
}
