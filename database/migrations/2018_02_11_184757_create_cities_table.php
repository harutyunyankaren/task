<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('geonameid')->unique();
            $table->string('name', 200);
            $table->string('asciiname', 200)->nullable();
            $table->string('alternatenames', 10000)->nullable();
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();
            $table->string('feature_class')->nullable();
            $table->string('feature_code',10)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('cc2', 200)->nullable();
            $table->string('admin1_code', 20)->nullable();
            $table->string('admin2_code', 80)->nullable();
            $table->string('admin3_code', 20)->nullable();
            $table->string('admin4_code', 20)->nullable();
            $table->bigInteger('population')->nullable();
            $table->integer('elevation')->nullable();
            $table->string('dem')->nullable();
            $table->string('timezone', 40)->nullable();
            $table->date('modification_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
