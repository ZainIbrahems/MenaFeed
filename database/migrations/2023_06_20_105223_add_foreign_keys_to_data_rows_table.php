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
        Schema::table('data_rows', function (Blueprint $table) {
            $table->foreign(['data_type_id'], 'fk_data_types_id')->references(['id'])->on('data_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_rows', function (Blueprint $table) {
            $table->dropForeign('fk_data_types_id');
        });
    }
};
