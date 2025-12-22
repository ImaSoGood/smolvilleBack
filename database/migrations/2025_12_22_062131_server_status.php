<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('server_status', function (Blueprint $table) {
            $table->id();
            $table->string('status', 128);
            $table->boolean('availible');
            $table->integer('code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('server_status');
    }
};
