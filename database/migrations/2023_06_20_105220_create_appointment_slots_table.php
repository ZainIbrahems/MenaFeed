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
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('provider_id')->nullable();
            $table->integer('appointment_type')->nullable();
            $table->timestamp('date_time')->nullable();
            $table->integer('facility_id')->nullable();
            $table->integer('professional_id')->nullable();
            $table->integer('fees')->nullable()->default(0);
            $table->integer('currency')->nullable();
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
        Schema::dropIfExists('appointment_slots');
    }
};
