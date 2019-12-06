<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('exam');
            $table->date('exam_date');
            $table->time('exam_time');
            $table->unsignedTinyInteger('exam_hours');
            $table->unsignedTinyInteger('exam_minutes');
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
        Schema::dropIfExists('exams');
    }
}
