<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_devices', function (Blueprint $table) {
        $table->increments('ID');
        $table->string('MachineAlias');
        $table->string('IP');
        $table->string('Port');
        $table->integer('MachineNumber');
        $table->boolean('Enabled')->default(true);
        $table->string('sn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_devices');
    }
}