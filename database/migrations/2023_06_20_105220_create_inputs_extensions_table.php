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
        Schema::create('inputs_extensions', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('platform_user_input_id')->index('fk_inputs_extensions_platform_user_input_id');
            $table->bigInteger('extension_id')->index('fk_inputs_extension_id');
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
        Schema::dropIfExists('inputs_extensions');
    }
};
