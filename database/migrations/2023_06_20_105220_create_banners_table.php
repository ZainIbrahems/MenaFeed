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
        Schema::create('banners', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('title', 1000);
            $table->bigInteger('platform_id')->index('fk_banners_platforms');
            $table->integer('home_section_id')->nullable();
            $table->text('url')->nullable();
            $table->string('resource_type', 1000)->nullable();
            $table->string('resource_id', 100)->nullable();
            $table->string('image', 1000);
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
        Schema::dropIfExists('banners');
    }
};
