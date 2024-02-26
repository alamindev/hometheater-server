<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_infos', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->string('keyword')->nullable();
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
        Schema::dropIfExists('meta_infos');
    }
}