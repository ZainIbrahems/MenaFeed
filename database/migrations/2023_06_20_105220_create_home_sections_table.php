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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 1000)->nullable();
            $table->string('home_section_type', 100)->default('video');
            $table->string('published', 10)->default('no');
            $table->integer('position')->nullable()->default(1);
            $table->integer('platform_id')->nullable();
            $table->string('design', 100)->nullable()->default('filter');
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
        Schema::dropIfExists('home_sections');
    }
};
