<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('students');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_number')->unique();
            $table->string('fullname');
            $table->string('gender');
            $table->string('state_of_origin')->nullable();
            $table->string('lga_of_origin')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mode_of_entry')->nullable();
            $table->string('first_choice')->nullable();
            $table->string('second_choice')->nullable();
            $table->string('o_level_1')->nullable();
            $table->string('o_level_2')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->boolean('admited')->default(0);
            $table->string('admission_number')->nullable();
            $table->string('vn_number');
            $table->string('password');
            $table->timestamps();
        });
    }
}
