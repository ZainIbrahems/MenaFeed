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
        Schema::create('meetings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 1000)->nullable();
            $table->date('date')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->string('time_zone', 100)->nullable();
            $table->string('repeat', 100)->nullable();
            $table->integer('require_passcode')->nullable()->default(0);
            $table->string('passcode', 100)->nullable();
            $table->integer('waiting_room')->nullable()->default(0);
            $table->integer('partipant_before_host')->nullable()->default(0);
            $table->integer('auto_record')->nullable()->default(0);
            $table->integer('to_calendar')->nullable()->default(0);
            $table->integer('share_permission')->nullable()->default(0);
            $table->integer('publish_to_feed')->nullable()->default(0);
            $table->integer('publish_to_live')->nullable();
            $table->integer('participants_type')->nullable();
            $table->integer('meeting_type')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('slug', 100)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
