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
        Schema::create('provider_feeds', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('text')->nullable();
            $table->text('file')->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('provider_id');
            $table->integer('can_comment')->default(1);
            $table->string('audience', 100)->nullable()->default('only_me');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->integer('feed_views')->default(0);
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
        Schema::dropIfExists('provider_feeds');
    }
};
