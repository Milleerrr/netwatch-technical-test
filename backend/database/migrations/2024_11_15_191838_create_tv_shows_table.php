<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTVShowsTable extends Migration
{
    public function up()
    {
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('release_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tv_shows');
    }
}
