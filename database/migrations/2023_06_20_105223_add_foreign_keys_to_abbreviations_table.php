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
        Schema::table('abbreviations', function (Blueprint $table) {
            $table->foreign(['platform_id'], 'fk_abbreviations_platform')->references(['id'])->on('platforms')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abbreviations', function (Blueprint $table) {
            $table->dropForeign('fk_abbreviations_platform');
        });
    }
};
