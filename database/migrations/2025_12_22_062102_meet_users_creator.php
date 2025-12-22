<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meet_users_creator', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('t_id');
            $table->string('token_id', 128);
            $table->string('rule_token', 128);
            $table->timestamps();
            
            $table->index('token_id');
            
            // Внимание: Внешний ключ на meet_rules будет добавлен позже
            // после создания обеих таблиц
        });
    }

    public function down()
    {
        Schema::dropIfExists('meet_users_creator');
    }
};
