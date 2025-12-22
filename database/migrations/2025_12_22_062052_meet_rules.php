<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meet_rules', function (Blueprint $table) {
            $table->id();
            $table->string('token_id', 128)->unique();
            $table->string('rule_token', 64);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meet_rules');
    }
};
