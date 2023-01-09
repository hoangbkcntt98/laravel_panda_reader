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
        Schema::create('data_formation_columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('column');
            $table->unsignedBigInteger('material_id');
            $table->string('column_name');
            $table->boolean('is_skipped')->default(false);
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
        Schema::dropIfExists('data_formation_columns');
    }
};
