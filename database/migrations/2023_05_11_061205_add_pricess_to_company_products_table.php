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
        Schema::table('company_products', function (Blueprint $table) {
            $table->decimal('price_2')->nullable()->default(0);
            $table->decimal('price_3')->nullable()->default(0);
            $table->decimal('price_4')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_products', function (Blueprint $table) {
            $table->dropColumn('price_2');
            $table->dropColumn('price_3');
            $table->dropColumn('price_4');
        });
    }
};
