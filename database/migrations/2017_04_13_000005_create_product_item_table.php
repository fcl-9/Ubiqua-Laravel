<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemTable extends Migration
{
    /**
     * Run the migrations.
     * @table product_item
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->float('actual_weight');
            $table->float('previous_weight');
            $table->dateTime('updated_on');
            $table->enum('state', ['IN', 'OUT']);
            $table->double('distance');
            $table->unsignedInteger('device_id');
            $table->unsignedInteger('lot_id');
            $table->unsignedInteger('lot_product_id');

            $table->index(["device_id"], 'fk_product_item_device1_idx');

            $table->index(["lot_id", "lot_product_id"], 'fk_product_item_lot1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('device_id', 'fk_product_item_device1_idx')
                ->references('id')->on('device')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('lot_id', 'fk_product_item_lot1_idx')
                ->references('id')->on('lot')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('product_item');
     }
}
