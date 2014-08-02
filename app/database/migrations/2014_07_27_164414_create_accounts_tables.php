<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('account_types', function(Blueprint $table)
        {
            $table->string('id', 100)->primary();
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
        });

        Schema::create('accounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('secret', 255);
            $table->string('account_type', 100);
            $table->foreign('account_type')->references('id')->on('account_types')->onDelete('cascade');
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->unique("name","account_type");


        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

        Schema::dropIfExists('accounts');
        Schema::dropIfExists('account_types');
	}

}
