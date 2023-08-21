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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('progress_date')->nullable();
            $table->string('reject_date')->nullable();
            $table->string('on_way_date')->nullable();
            $table->string('deliverd_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('progress_date');
            $table->dropColumn('reject_date');
            $table->dropColumn('on_way_date');
            $table->dropColumn('deliverd_date');

        });
    }
};
