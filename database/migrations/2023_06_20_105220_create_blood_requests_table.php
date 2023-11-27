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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 1000);
            $table->string('mobile', 100);
            $table->string('blood_type', 100);
            $table->string('unit_quantity', 1000);
            $table->string('hospital', 1000);
            $table->geometry('location');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->string('user_type', 1000)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('click_type', 100)->nullable()->default('call');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blood_requests');
    }
};
