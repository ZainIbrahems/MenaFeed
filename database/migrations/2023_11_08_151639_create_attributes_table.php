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
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 1000);
            $table->bigInteger('attribute_type_id')->nullable()->index('fk_marketplace_attributes_attribute_type_id');
            $table->bigInteger('platform_id')->nullable()->index('fk_marketplace_attributes_platform_id');
            $table->bigInteger('item_category_id')->nullable()->index('fk_marketplace_attributes_item_category_id');
            $table->bigInteger('item_sub_category_id')->nullable()->index('fk_marketplace_attributes_item_sub_category_id');
            $table->boolean('validation_rule_required')->nullable();
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
        Schema::dropIfExists('attributes');
    }
};
