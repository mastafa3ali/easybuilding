<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
        });
        Schema::table('company_products', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('title_en');
            $table->dropColumn('title_ar');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('title_en');
            $table->dropColumn('title_ar');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('name_ar');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('name_ar');
            $table->dropColumn('description_en');
            $table->dropColumn('description_ar');
        });


    }
};
