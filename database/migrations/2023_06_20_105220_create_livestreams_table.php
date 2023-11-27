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
        Schema::create('livestreams', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('image')->nullable();
            $table->string('title', 1000)->nullable();
            $table->string('goal', 1000)->nullable();
            $table->string('topic', 1000)->nullable();
            $table->integer('platform_id');
            $table->integer('live_now_category_id');
            $table->timestamp('date_time')->useCurrentOnUpdate()->useCurrent();
            $table->integer('duration');
            $table->string('status', 10);
            $table->string('live_record', 1000)->nullable();
            $table->text('report_message')->nullable();
            $table->string('room_id', 100)->nullable();
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
        Schema::dropIfExists('livestreams');
    }
};
