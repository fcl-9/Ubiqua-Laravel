<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLaravelTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("device", function (Blueprint $table) {
            $table->dropColumn("updated_on");
            $table->timestamps();
        });
        Schema::table("product", function (Blueprint $table) {
            $table->dropColumn("updated_on");
            $table->timestamps();
        });
        Schema::table("device_has_users", function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table("lot", function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table("product_item", function (Blueprint $table) {
            $table->dropColumn("updated_on");
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
        //
    }
}
