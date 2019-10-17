<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commun_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->decimal('total_sum',10,2)->default('0.00');
            $table->decimal('payed_sum',10,2)->default('0.00');
            $table->boolean('status_save')->default('0');
            $table->boolean('status_pay')->default('0');
            $table->string('monthName')->nullable();

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
        Schema::dropIfExists('commun_bills');
    }
}
