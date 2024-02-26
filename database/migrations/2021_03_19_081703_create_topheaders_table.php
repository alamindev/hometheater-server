<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopheadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topheaders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('details');
            $table->string('btn_text');
            $table->string('btn_link');
            $table->string('second_btn_text');
            $table->string('second_btn_link');
            $table->string('image');
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
        Schema::dropIfExists('topheaders');
    }
}