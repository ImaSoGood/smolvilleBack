<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meet_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meet_id')->constrained('meet_meetings')->onDelete('cascade');
            $table->bigInteger('user_id');
            $table->dateTime('watch_time');
            $table->timestamps();
            
            $table->index('meet_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('meet_views');
    }
};