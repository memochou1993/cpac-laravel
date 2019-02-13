<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('creator')->nullable();
            $table->string('subject')->nullable();
            $table->string('description')->nullable();
            $table->string('publisher')->nullable();
            $table->string('contributor')->nullable();
            $table->smallInteger('date')->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->string('identifier')->nullable();
            $table->string('source')->nullable();
            $table->string('language')->nullable();
            $table->string('relation')->nullable();
            $table->string('coverage')->nullable();
            $table->string('rights')->nullable();
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
        Schema::dropIfExists('books');
    }
}
