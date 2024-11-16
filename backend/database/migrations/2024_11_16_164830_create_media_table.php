<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->text('overview');
            $table->float('popularity');
            $table->string('image');
            $table->float('vote_average');
            $table->integer('vote_count');
            $table->json('cast');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
}
