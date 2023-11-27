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
        Schema::create('providers_publications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('paper_title', 1000);
            $table->text('summary')->nullable();
            $table->string('publisher', 1000);
            $table->string('published_url', 1000);
            $table->date('published_date');
            $table->integer('sort')->default(0);
            $table->integer('provider_id');
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('providers_publications');
    }
};
