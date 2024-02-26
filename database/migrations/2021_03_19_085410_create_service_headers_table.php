<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_headers', function (Blueprint $table) {
            $table->id();
            $table->string('home_title')->nullable();
            $table->text('home_details')->nullable();
            $table->string('service_title')->nullable();
            $table->text('service_details')->nullable();
            $table->string('service_btn_text')->nullable();
            $table->string('service_btn_link')->nullable();
            $table->string('image')->nullable();
            $table->string('booking_title')->nullable();
            $table->text('booking_details')->nullable();
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
        Schema::dropIfExists('service_headers');
    }
}
