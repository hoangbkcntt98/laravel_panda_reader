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
        Schema::create('adverb', function (Blueprint $table) {
            $table->id();
            $table->integer('no')->nullable();
            $table->string('chapter_name')->nullable();
            $table->string('topic_name')->nullable();
            $table->string('word')->nullable();
            $table->string('meaning')->nullable();
            $table->string('sentence')->nullable();
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
        Schema::dropIfExists('adverb');
    }
};
