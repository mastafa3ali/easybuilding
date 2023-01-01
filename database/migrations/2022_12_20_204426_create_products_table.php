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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->tinyInteger('type');
            $table->tinyInteger('properties');
            $table->decimal('guarantee_amount', 10)->default(0);
            $table->decimal('price', 10);
            $table->foreignId('company_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->references('id')->on('categories')->constrained()->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
