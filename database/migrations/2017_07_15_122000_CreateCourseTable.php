<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course',function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->text('course_note');
            $table->string('course_css');
            $table->date('date');
            $table->string('start_time',50);
            $table->string('end_time',50);
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
