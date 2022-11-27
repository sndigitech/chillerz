<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();            
            $table->string('name')->nullable();
            $table->text('about')->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('mobile', 15)->unique()->nullable();
            $table->string('otp', 4)->nullable();           
            $table->string('source', 11)->nullable()->comment('social => google or facebook, manual => email or mobile');
            $table->string('password')->default('password');
            $table->string('gender', 6)->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('user_type')->nullable()->comment('user_type = 1 for User, user_type = 2 for vendor');
            $table->smallInteger('follower_count')->default(0);
            $table->smallInteger('liked_event_count')->default(0);
            $table->smallInteger('liked_artist_count')->default(0);
            $table->string('prefrences')->nullable();
            $table->string('status')->default('Inactive')->comment('Active, Inactive, Discarded');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();            
            $table->string('api_token')->unique()->nullable();
            $table->tinyInteger('isVerified')->default(0);          
            $table->string('tags')->nullable();

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
        Schema::dropIfExists('users');
    }
}
