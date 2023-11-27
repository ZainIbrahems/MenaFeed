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
        Schema::create('jobs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 1000);
            $table->integer('provider_id');
            $table->text('short_description');
            $table->integer('type_id');
            $table->integer('classification_id');
            $table->string('address_text', 1000)->nullable();
            $table->text('core_expertise');
            $table->text('summary');
            $table->string('video', 1000)->nullable();
            $table->geometry('location')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
