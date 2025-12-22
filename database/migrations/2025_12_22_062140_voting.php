<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('voting', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512);
            $table->string('description', 512);
            $table->string('status', 16);
            $table->dateTime('created_at');
            $table->string('image_url', 128)->nullable();
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('voting');
    }
};
