<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('about');
            $table->string('email');
            $table->string('service_names')->default(null);
            $table->text('about_service');            
            $table->string('contact_person_name');
            $table->string('contact_person_id');
            $table->string('status')->default(0)->comment('0 for disable, 1 for enable'); 
            $table->string('cover_photo');
            $table->string('city');
            $table->string('website');
            $table->string('social_platforms'); 
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
        Schema::dropIfExists('organizers');
    }
}
