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
        Schema::create('countries_states', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('sub_of')->nullable()->index('fk_sub_of_countires');
            $table->string('name', 256)->nullable();
            $table->boolean('capital')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries_states');
    }
};
