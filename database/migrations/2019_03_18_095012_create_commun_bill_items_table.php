<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunBillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commun_bill_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('commun_bill_id');
            $table->integer('commun_field_id');
            $table->integer('last_val')->nullable();
            $table->integer('next_val')->nullable();
            $table->decimal('sum',10,2)->default('0.00');
            $table->boolean('status_save')->default('0');
            $table->boolean('status_pay')->default('0');
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
        Schema::dropIfExists('commun_bill_items');
    }
}
