<?php

use Flashpoint\Fuel\Migrations\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateFlightsCollection extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $schema) {
            $schema->index('flightNumber');
        });
    }

    public function down()
    {
        Schema::drop('flights');
    }
}
