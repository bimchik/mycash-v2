<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->decimal('total_sum',10,2)->default('0.00');
            $table->boolean('confirmed')->default('0');
            $table->boolean('saved')->default('0');
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
        Schema::dropIfExists('buy_lists');
    }
}
