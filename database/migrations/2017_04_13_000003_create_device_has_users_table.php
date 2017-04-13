<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @table device_has_users
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_has_users', function (Blueprint $table) {
            $table->increments('device_id');
            $table->unsignedInteger('users_id');

            $table->index(["users_id"], 'fk_device_has_users_users1_idx');

            $table->index(["device_id"], 'fk_device_has_users_device1_idx');


            $table->foreign('device_id', 'fk_device_has_users_device1_idx')
                ->references('id')->on('device')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('users_id', 'fk_device_has_users_users1_idx')
                ->references('id')->on('users')
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
       Schema::dropIfExists('device_has_users');
     }
}
