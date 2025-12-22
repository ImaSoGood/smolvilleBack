<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vote_params', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_id')->constrained('voting')->onDelete('cascade');
            $table->string('title', 128);
            $table->string('image_url', 128)->nullable();
            $table->timestamps();
            
            $table->index('voting_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vote_params');
    }
};
