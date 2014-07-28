<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('tags', function(Blueprint $table)
        {

            $table->increments('id');
            $table->string('tag');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(array('tag','user_id'));

            $table->integer('account_id')->nullable()->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->timestamps();

        });

        Schema::create('badge_tag', function(Blueprint $table)
        {


            $table->integer('badge_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->primary(array('badge_id','tag_id'));

            $table->foreign('badge_id')->references('id')->on('badges');

            $table->foreign('tag_id')->references('id')->on('tags');

            $table->timestamp('tagged_on');

        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::dropIfExists('badge_tag');
        Schema::dropIfExists('tags');

	}

}
