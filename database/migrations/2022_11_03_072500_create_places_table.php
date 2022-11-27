<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('placetype_id'); 
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('logo')->nullable();
            $table->string('photos')->nullable();
            $table->string('videos')->nullable(); 

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
