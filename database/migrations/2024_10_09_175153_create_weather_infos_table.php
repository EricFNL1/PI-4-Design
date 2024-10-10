<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/xxxx_xx_xx_create_weather_infos_table.php
class CreateWeatherInfosTable extends Migration
{
    public function up()
    {
        Schema::create('weather_infos', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('temperature');
            $table->string('weather_description');
            $table->string('timezone');
            $table->timestamp('date_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_infos');
    }
}
