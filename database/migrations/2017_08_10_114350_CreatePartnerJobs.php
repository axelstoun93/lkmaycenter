<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners_job', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('job_title');
            $table->string('job_category');
            $table->text('duties');
            $table->text('demand');
            $table->string('work_experience');
            $table->text('condition');
            $table->string('salary');
            $table->string('working_schedule');
            $table->timestamps();
        });  //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('partners_job');
    }
}
