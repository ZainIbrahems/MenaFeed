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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id')->nullable()->index('users_role_id_foreign');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('personal_picture')->nullable()->default('users/default.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->rememberToken();
            $table->text('settings')->nullable();
            $table->string('fcm_token', 1000)->nullable();
            $table->integer('status')->default(0);
            $table->integer('platform_id')->nullable();
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
        Schema::dropIfExists('users');
    }
};
