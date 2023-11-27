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
        Schema::create('providers_cme', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 1000)->nullable();
            $table->string('source_type', 1000)->nullable();
            $table->string('cme_accredited_by', 1000)->nullable();
            $table->integer('points')->nullable()->default(0);
            $table->string('certificate', 1000)->nullable();
            $table->string('start_year', 1000)->nullable();
            $table->string('end_year', 1000)->nullable();
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
        Schema::dropIfExists('providers_cme');
    }
};
