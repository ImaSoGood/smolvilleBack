<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512);
            $table->dateTime('date');
            $table->string('type', 64);
            $table->string('description', 512);
            $table->string('location', 512);
            $table->string('map_link', 256);
            $table->string('image_url', 128)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};