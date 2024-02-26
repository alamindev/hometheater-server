<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_infos', function (Blueprint $table) {
            $table->id();
            $table->string('social_datas')->nullable(); 
            $table->string('address_datas')->nullable(); 
            $table->text('service_location')->nullable();
            $table->text('hrs_operation')->nullable();
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
        Schema::dropIfExists('social_infos');
    }
}