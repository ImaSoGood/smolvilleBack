<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meet_visit', function (Blueprint $table) {
            $table->id();
            $table->string('meet_token', 128);
            $table->foreignId('meeting_id')->constrained('meet_meetings')->onDelete('cascade');
            $table->bigInteger('user_id');
            $table->timestamps();
            
            $table->index('meeting_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('meet_visit');
    }
};
