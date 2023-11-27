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
        Schema::create('providers_educations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('university_name', 1000);
            $table->string('degree', 1000);
            $table->integer('sort')->default(0);
            $table->string('starting_year', 4)->nullable();
            $table->string('ending_year', 4)->nullable();
            $table->integer('currently_pursuing')->nullable()->default(0);
            $table->integer('provider_id');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers_educations');
    }
};
