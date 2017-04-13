<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotTable extends Migration
{
    /**
     * Run the migrations.
     * @table lot
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lot', function (Blueprint $table) {
            $table->increments('id');
            $table->date('expiration_date');
            $table->unsignedInteger('product_id');

            $table->index(["product_id"], 'fk_Lote_product1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('product_id', 'fk_Lote_product1_idx')
                ->references('id')->on('product')
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
       Schema::dropIfExists('lot');
     }
}
