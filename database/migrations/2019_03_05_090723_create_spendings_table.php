<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->integer('category_id');
            $table->integer('loc_tag_id')->nullable();
            $table->integer('tag_id')->nullable();
            $table->decimal('qty',10,3)->default('0.000');
            $table->decimal('total_price', 10,2)->default('0.00');
            $table->boolean('commun_bill')->default(false);
            $table->integer('bill_id')->nullable();
            $table->integer('ballance_id');
            $table->integer('ballance_type_id');
            $table->integer('day');
            $table->string('operation_type');
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
        Schema::dropIfExists('spendings');
    }
}
