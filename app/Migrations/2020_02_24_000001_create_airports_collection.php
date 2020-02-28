<?php

use Flashpoint\Fuel\Migrations\Schema;
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateAirportsCollection extends Migration
{
    public function up()
    {
        Schema::create('airports', function (Blueprint $schema) {
            $schema->index('code');
        });
    }

    public function down()
    {
        Schema::drop('airports');
    }
}
