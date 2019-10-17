<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commun_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->string('name');
            $table->string('calcBy')->nullable();
            $table->integer('people_count')->nullable();
            $table->integer('current_count_value')->nullable();
            $table->decimal('space_count',10,2)->nullable();
            $table->decimal('tariff_price',10,2)->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commun_fields');
    }
}
