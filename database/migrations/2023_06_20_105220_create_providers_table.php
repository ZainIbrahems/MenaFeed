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
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('recovery_email', 100)->nullable();
            $table->string('personal_picture')->nullable()->default('users/default.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone', 50)->nullable();
            $table->integer('phone_verified')->nullable()->default(0);
            $table->rememberToken();
            $table->text('settings')->nullable();
            $table->string('fcm_token', 1000)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('verified')->nullable()->default(0);
            $table->integer('platform_id')->nullable();
            $table->integer('abbreviation_id')->nullable();
            $table->text('summary')->nullable();
            $table->geometry('location')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->string('registration_number', 500)->nullable();
            $table->integer('provider_type_id')->nullable()->default(1);
            $table->string('qualification_certificate', 1000)->nullable();
            $table->string('professional_license', 1000)->nullable();
            $table->string('address', 1000)->nullable();
            $table->text('about')->nullable();
            $table->string('website', 100)->nullable();
            $table->string('public_email', 100)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('whatsapp', 100)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('pinterest', 100)->nullable();
            $table->string('youtube', 100)->nullable();
            $table->string('tiktok', 100)->nullable();
            $table->integer('added_by')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('platform_category')->nullable();
            $table->string('type_str', 20)->nullable()->default('provider');
            $table->integer('is_live')->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('providers');
    }
};
