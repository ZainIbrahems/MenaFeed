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
        Schema::create('platform_user_inputs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 1000);
            $table->string('title', 1000);
            $table->string('description', 1000)->nullable();
            $table->string('type', 1000);
            $table->integer('required')->default(0);
            $table->bigInteger('platform_id')->index('fk_platform_user_inputs_platforms');
            $table->integer('spciality_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
        Schema::dropIfExists('platform_user_inputs');
    }
};
