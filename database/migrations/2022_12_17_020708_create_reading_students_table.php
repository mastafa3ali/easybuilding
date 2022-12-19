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
        Schema::create('reading_students', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('part_1')->default(0);
            $table->tinyInteger('part_2')->default(0);
            $table->tinyInteger('part_3')->default(0);
            $table->tinyInteger('part_4')->default(0);
            $table->tinyInteger('part_5')->default(0);
            $table->tinyInteger('part_6')->default(0);
            $table->tinyInteger('part_7')->default(0);
            $table->tinyInteger('part_8')->default(0);
            $table->tinyInteger('part_9')->default(0);
            $table->tinyInteger('part_10')->default(0);
            $table->tinyInteger('part_11')->default(0);
            $table->tinyInteger('part_12')->default(0);
            $table->tinyInteger('part_13')->default(0);
            $table->tinyInteger('part_14')->default(0);
            $table->tinyInteger('part_15')->default(0);
            $table->tinyInteger('part_16')->default(0);
            $table->tinyInteger('part_17')->default(0);
            $table->tinyInteger('part_18')->default(0);
            $table->tinyInteger('part_19')->default(0);
            $table->tinyInteger('part_20')->default(0);
            $table->tinyInteger('part_21')->default(0);
            $table->tinyInteger('part_22')->default(0);
            $table->tinyInteger('part_23')->default(0);
            $table->tinyInteger('part_24')->default(0);
            $table->tinyInteger('part_25')->default(0);
            $table->tinyInteger('part_26')->default(0);
            $table->tinyInteger('part_27')->default(0);
            $table->tinyInteger('part_28')->default(0);
            $table->tinyInteger('part_29')->default(0);
            $table->tinyInteger('part_30')->default(0);
            $table->foreignId('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('readingcycle_id')->references('id')->on('readingcycles')->cascadeOnDelete();
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
        Schema::dropIfExists('reading_students');
    }
};
