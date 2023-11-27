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
        Schema::create('geo_ip', function (Blueprint $table) {
            $table->double('start_range');
            $table->double('end_range');
            $table->string('country_short', 2);
            $table->string('country_full', 32);

            $table->index(['start_range', 'end_range'], 'start_range');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geo_ip');
    }
};
