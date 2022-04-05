<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('banner_title')->nullable();
            $table->mediumText('banner_description')->nullable();
            $table->string('banner_home')->nullable();
            $table->string('banner_home_title')->nullable();
            $table->mediumText('banner_home_description')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('copyright')->nullable();
            $table->mediumText('link_fanpage')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
