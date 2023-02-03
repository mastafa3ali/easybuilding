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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('address');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('delivery_phone')->nullable();
            $table->string('area')->nullable();
            $table->longText('details')->nullable();
            $table->string('attachment1')->nullable();
            $table->string('attachment2')->nullable();
            $table->date('delivery_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('payment')->default(1);
            $table->decimal('guarantee_amount')->default(0);
            $table->decimal('total')->default(0);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('orders');
    }
};
