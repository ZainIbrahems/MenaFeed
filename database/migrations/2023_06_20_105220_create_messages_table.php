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
        Schema::create('messages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('message');
            $table->text('files')->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('from_id');
            $table->integer('to_id');
            $table->timestamp('read_at')->nullable();
            $table->integer('chat_id');
            $table->integer('from_deleted')->default(0);
            $table->integer('to_deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
        Schema::dropIfExists('messages');
    }
};
