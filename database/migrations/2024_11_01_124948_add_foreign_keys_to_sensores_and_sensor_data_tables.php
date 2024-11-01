<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSensoresAndSensorDataTables extends Migration
{
    public function up()
    {
        Schema::table('sensores', function (Blueprint $table) {
            // Adiciona coluna 'estufa_id' como chave estrangeira na tabela 'sensores'
            $table->unsignedBigInteger('estufa_id')->nullable()->after('tipo'); // Adiciona após a coluna 'tipo'
            $table->foreign('estufa_id')->references('id')->on('estufas')->onDelete('cascade');
        });

        Schema::table('sensor_data', function (Blueprint $table) {
            // Adiciona coluna 'sensor_id' como chave estrangeira na tabela 'sensor_data'
            $table->unsignedBigInteger('sensor_id')->nullable()->after('id');
            $table->foreign('sensor_id')->references('id')->on('sensores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('sensores', function (Blueprint $table) {
            // Remove a chave estrangeira e a coluna 'estufa_id'
            $table->dropForeign(['estufa_id']);
            $table->dropColumn('estufa_id');
        });

        Schema::table('sensor_data', function (Blueprint $table) {
            // Remove a chave estrangeira e a coluna 'sensor_id'
            $table->dropForeign(['sensor_id']);
            $table->dropColumn('sensor_id');
        });
    }
}
