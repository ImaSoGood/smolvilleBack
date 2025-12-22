<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('meet_users_creator', function (Blueprint $table) {
            $table->foreign('token_id')->references('token_id')->on('meet_rules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('meet_users_creator', function (Blueprint $table) {
            $table->dropForeign(['token_id']);
        });
    }
};
