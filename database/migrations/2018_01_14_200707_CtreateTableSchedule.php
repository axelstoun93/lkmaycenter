<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CtreateTableSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule',function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('place');
            $table->text('note');
            $table->string('schedule_css');
            $table->integer('category_id')->unsigned();
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
        Schema::drop('schedule');
    }
}
