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
        Schema::create('items', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('product_id')->nullable()->index('fk_items_product_id');
             $table->string('sku', 1000)->nullable();
             $table->string('images', 1000)->nullable();
            $table->string('video', 1000)->nullable();
            $table->string('3d_image',1000)->nullable();
            $table->string('virtual_tower',1000)->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('discount');
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->geometry('location')->nullable();
//            $table->string('attributes',1000)->nullable();
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
        Schema::dropIfExists('items');
    }
};
