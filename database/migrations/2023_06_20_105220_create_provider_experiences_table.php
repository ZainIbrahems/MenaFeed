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
        Schema::create('provider_experiences', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('place_of_work', 1000);
            $table->string('designation', 1000);
            $table->string('starting_year', 100)->nullable();
            $table->string('ending_year', 100)->nullable();
            $table->integer('currently_working')->nullable()->default(0);
            $table->integer('sort')->default(0);
            $table->integer('provider_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_experiences');
    }
};
