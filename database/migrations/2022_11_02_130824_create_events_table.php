<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('genre_id')->nullable()->index();
            $table->string('name');
            $table->string('artist_name')->nullable();            
            $table->string('s_date_time')->nullable();
            $table->string('e_date_time')->nullable();
            $table->string('place')->nullable();
            $table->text('details')->nullable();
            $table->text('why_event')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->tinyInteger('interested')->default(0)->comment('0 => disable, 1 => enable');
            $table->tinyInteger('review_feedback')->default(0)->comment('0 => disable, 1 => enable review and feedback');
            $table->tinyInteger('like_follow')->default(0)->comment('0 => disable, 1 => enable like and follow');
            $table->string('cover_image')->nullable();
            $table->string('address_of_the_place')->nullable();
            $table->string('direction_of_the_place')->nullable();
            $table->string('banners')->nullable();
            $table->string('featured_image')->nullable();                       
            $table->string('people_attending')->nullable();
            $table->enum('event_pay_type',array('free','paid'))->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('discount')->nullable();
            $table->string('coupon')->nullable()->comment('also called voucher');          
            $table->unsignedBigInteger('status')->default(2)->index()->comment('1 => Published,2 => Draft, 3 => Canceled');
           
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
        Schema::dropIfExists('events');
    }
}
