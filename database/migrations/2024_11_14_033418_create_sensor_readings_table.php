<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorReadingsTable extends Migration
{
    public function up()
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->float('temperature');
            $table->float('humidity');
            $table->float('soil_moisture');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_readings');
    }
}
