<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('asciiname')->nullable(); 
            $table->string('latitude');
            $table->string('longitude');
            $table->string('feature_class')->nullable(); 
            $table->string('feature_code')->nullable(); 
            $table->string('country_code')->nullable();
            $table->string('cc2')->nullable(); 
            $table->string('admin1_code')->nullable(); 
            $table->string('admin2_code')->nullable(); 
            $table->string('admin3_code')->nullable(); 
            $table->string('admin4_code')->nullable(); 
            $table->string('population')->nullable(); 
            $table->string('elevation')->nullable(); 
            $table->string('dem')->nullable(); 
            $table->string('timezone')->nullable();
            $table->timestamps();
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