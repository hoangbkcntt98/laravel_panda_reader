<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grammar', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('word')->nullable();
            $table->string('sentence')->nullable();
            $table->string('meaning')->nullable();
            $table->string('connection')->nullable();
            $table->string('usage')->nullable();
            $table->string('warning')->nullable();
            $table->string('related_grammar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grammar');
    }
};
