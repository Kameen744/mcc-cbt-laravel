<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lib_resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('res_title');
            $table->string('res_subject');
            $table->string('res_author');
            $table->string('res_type_id');
            $table->string('res_department_id');
            $table->string('res_files');
            $table->string('res_cover');
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
        Schema::dropIfExists('lib_resources');
    }
}
