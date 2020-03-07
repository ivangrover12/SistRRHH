<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkinout', function (Blueprint $table) {
            $table->string('USERID');
            $table->string('CHECKTIME');
            $table->string('CHECKTYPE');
            $table->integer('VERIFYCODE');
            $table->integer('SENSORID');
            $table->string('Memoinfo');
            $table->string('WorkCode');
            $table->string('sn');
            $table->string('UserExtFmt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkinout');
    }
}
