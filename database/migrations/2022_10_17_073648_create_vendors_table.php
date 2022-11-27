<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();         
            $table->unsignedBigInteger('placetype_id')->nullable()->index();                                    
            $table->string('name')->nullable(); 
            $table->text('description')->nullable();        
            $table->string('email', 100)->unique()->nullable();
            $table->string('password')->default('password');
            $table->string('contact_number', 15)->unique()->nullable();            
            $table->string('logo')->nullable();
            $table->string('photos')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('videos')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable()->index(); 
            $table->unsignedBigInteger('country_id')->nullable()->index();             
            $table->string('website')->nullable();
            $table->string('lat_tude')->nullable();
            $table->string('long_tude')->nullable();                  
            $table->dateTime('start_time', 0)->nullable();
            $table->dateTime('end_time', 0)->nullable();            
            $table->unsignedBigInteger('status')->default(2)->index()->comment('1 => Active, 2 => Inactive, 3 => Discarded');           
            $table->string('tags')->nullable()->comment('separate each tag with #');
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
        Schema::dropIfExists('vendors');
    }
}
