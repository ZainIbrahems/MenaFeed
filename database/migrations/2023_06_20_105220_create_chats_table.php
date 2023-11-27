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
        Schema::create('chats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('from_id');
            $table->string('from_type', 100);
            $table->integer('to_id');
            $table->string('to_type', 100);
            $table->text('last_message');
            $table->integer('last_message_from')->nullable();
            $table->integer('from_deleted')->default(0);
            $table->timestamp('from_deleted_at')->nullable();
            $table->integer('to_deleted')->default(0);
            $table->timestamp('to_deleted_at')->nullable();
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
        Schema::dropIfExists('chats');
    }
};
