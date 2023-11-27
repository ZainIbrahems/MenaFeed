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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->unique();
            $table->string('personal_picture')->nullable()->default('users/default.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->integer('phone_verified')->default(0);
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->rememberToken();
            $table->text('settings')->nullable();
            $table->string('fcm_token', 1000)->nullable();
            $table->integer('status')->default(0);
            $table->integer('platform_id')->nullable();
            $table->string('type_str', 10)->nullable()->default('client');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
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
        Schema::dropIfExists('clients');
    }
};
