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
        Schema::create('provider_awards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 1000);
            $table->string('authority_name', 1000)->nullable();
            $table->string('year', 10)->nullable();
            $table->integer('sort');
            $table->integer('provider_id');
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
        Schema::dropIfExists('provider_awards');
    }
};
