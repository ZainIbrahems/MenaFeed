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
        Schema::create('provider_feeds_comments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('user_type', 100);
            $table->text('comment');
            $table->integer('feed_id');
            $table->integer('comment_id')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_feeds_comments');
    }
};
