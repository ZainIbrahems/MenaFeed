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
        Schema::create('upcoming_livestreams', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('image', 1000)->nullable();
            $table->string('title', 1000)->nullable();
            $table->string('goal', 1000)->nullable();
            $table->string('topic', 1000)->nullable();
            $table->integer('platform_id');
            $table->integer('upcoming_livestreams_id');
            $table->dateTime('date_time');
            $table->string('status', 20)->nullable();
            $table->integer('added_by');
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('upcoming_livestreams');
    }
};
