<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaGenresTable extends Migration
{
    public function up()
    {
        Schema::create('media_genres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['media_id', 'genre_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_genres');
    }
}
