<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function ($table) {
			$table->increments('id')->unique();
			$table->string('name');
			$table->string('path',550);
			$table->string('description',550);
			$table->string('ext');
			$table->integer('gallery_id')->unsigned()->nullable();
			$table->char('status',1)->default(0);
            $table->timestamps();
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade')->onUpdate('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media');
    }
}