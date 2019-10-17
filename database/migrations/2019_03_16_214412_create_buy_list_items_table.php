<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_list_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('buylist_id');
            $table->integer('tag_id');
            $table->boolean('status')->default('0');
            $table->decimal('payed_sum',10,2)->default('0.00');
            $table->decimal('qty',10,3)->default('0.000');
            $table->integer('location_id')->nullable();
            $table->integer('loc_tag_id')->nullable();
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
        Schema::dropIfExists('buy_list_items');
    }
}
