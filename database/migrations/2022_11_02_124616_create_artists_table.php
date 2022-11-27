<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();           
            $table->unsignedBigInteger('artisttype_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_number')->nullable();
            $table->text('about')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('photo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('featured_image')->nullable();            
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->unsignedBigInteger('country_id')->nullable()->index();          
            $table->string('website')->nullable();
            $table->string('social_platform')->nullable();
            $table->tinyInteger('followers_count')->default(0);
            $table->string('profile_sharing_counts')->nullable();           
            $table->unsignedBigInteger('status')->default(2)->index()->comment('1 => Active,2 => Inactive, 3 => Discarded'); 
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
        Schema::dropIfExists('artists');
    }
}
