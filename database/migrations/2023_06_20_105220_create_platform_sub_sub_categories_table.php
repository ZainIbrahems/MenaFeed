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
        Schema::create('platform_sub_sub_categories', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 1000);
            $table->bigInteger('sub_category_id')->index('fk_platform_sub_sub_categories');
            $table->integer('ranking')->default(1);
            $table->string('image', 1000)->nullable();
            $table->string('design', 1000)->nullable()->default('filter');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
        Schema::dropIfExists('platform_sub_sub_categories');
    }
};
