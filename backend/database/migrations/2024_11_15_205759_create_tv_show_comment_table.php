<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTVShowCommentTable extends Migration
{
    public function up()
    {
        Schema::create('tv_show_comment', function (Blueprint $table) {
            $table->unsignedBigInteger('tv_show_id');
            $table->unsignedBigInteger('comment_id');

            $table->foreign('tv_show_id')->references('id')->on('tv_shows')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');

            $table->primary(['tv_show_id', 'comment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tv_show_comment');
    }
}
