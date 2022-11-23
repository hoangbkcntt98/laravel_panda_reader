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
        Schema::create('kanji', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('level')->nullable();
            $table->string('chapter_no')->nullable();
            $table->string('chapter_name')->nullable();
            $table->string('kanji')->nullable();
            $table->string('meaning')->nullable();
            $table->string('vn_cn')->nullable();
            $table->string('reading')->nullable();
            $table->string('how_to_remember')->nullable();
            $table->string('word')->nullable();
            $table->string('sentence')->nullable();
            $table->string('practive')->nullable();
            $table->string('homonym')->nullable();
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
        Schema::dropIfExists('kanji');
    }
};
