<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vote_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_id')->constrained('voting')->onDelete('cascade');
            $table->foreignId('vote_params_id')->constrained('vote_params')->onDelete('cascade');
            $table->bigInteger('user_id');
            $table->timestamps();
            
            $table->index('voting_id');
            $table->index('vote_params_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vote_user');
    }
};
