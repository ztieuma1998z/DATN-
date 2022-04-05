<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollcallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rollcalls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('schedule_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('teacher_id')->nullable();
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
        Schema::dropIfExists('rollcalls');
    }
}
