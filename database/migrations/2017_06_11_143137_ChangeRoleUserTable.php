<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('role_user',function (Blueprint $table)
       {
           $table->integer('user_id')->after('id')->unsigned()->default(3);
           $table->foreign('user_id')->references('id')->on('users');
           $table->integer('role_id')->after('user_id')->unsigned()->default(3);
           $table->foreign('role_id')->references('id')->on('roles');
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