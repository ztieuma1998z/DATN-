<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default(0);
            $table->string('full_name')->nullable();
            $table->string('password')->default(0);
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->integer('specialized_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('gender')->default(1)->index();
            $table->integer('status')->default(1)->index();
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
        Schema::dropIfExists('teachers');
    }
}
