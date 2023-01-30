<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained();
            $table->string('name');
            $table->string('office_phone');
            $table->string('first_mng_name');
            $table->string('first_phone');
            $table->string('second_mng_name');
            $table->string('second_phone');
            $table->string('email')->unique()->nullable();
            $table->foreignId('location_id')->constrained();
            $table->unique(['name', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
