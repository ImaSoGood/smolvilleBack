<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meet_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meet_token', 128)->unique();
            $table->string('user_token_id', 128);
            $table->string('description', 1024);
            $table->dateTime('date');
            $table->string('title', 256);
            $table->string('image_url', 128);
            $table->string('type', 64);
            $table->integer('age_limit');
            $table->string('location', 256);
            $table->string('map_link', 512);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meet_meetings');
    }
};
