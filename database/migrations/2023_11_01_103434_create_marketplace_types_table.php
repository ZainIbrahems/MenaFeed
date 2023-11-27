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
        Schema::create('marketplace_types', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 1000);
            $table->bigInteger('platform_id')->nullable()->index('fk_marketplace_types_platform_id');
            $table->bigInteger('platform_category_id')->nullable()->index('fk_marketplace_types_platform_category_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
//            $table->string('image', 1000)->nullable();
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
        Schema::dropIfExists('marketplace_types');
    }
};
