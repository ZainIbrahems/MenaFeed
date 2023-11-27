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
        Schema::create('appointment_clients', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('for_who')->nullable()->default(1);
            $table->integer('professional_id')->nullable();
            $table->integer('facility_id')->nullable();
            $table->integer('appointment_slot_id');
            $table->string('full_name', 1000)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('id_number', 50)->nullable();
            $table->string('mobile_number', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('id_front', 500)->nullable();
            $table->string('id_back', 500)->nullable();
            $table->string('insurance_front', 500)->nullable();
            $table->string('insurance_back', 500)->nullable();
            $table->text('comments')->nullable();
            $table->string('payment_status', 50)->nullable()->default('unpaid');
            $table->string('state', 50)->nullable()->default('new');
            $table->integer('user_id')->nullable();
            $table->string('from_type', 10)->nullable()->default('client');
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
        Schema::dropIfExists('appointment_clients');
    }
};
