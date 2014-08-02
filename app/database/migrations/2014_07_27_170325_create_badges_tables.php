<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('issuers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('origin');
            $table->string('name');
            $table->string('contact');
            $table->integer("user_id")->unique()->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(array('origin','name','contact'));
            $table->softDeletes();

        });


            Schema::create('badges', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('version',10);
            $table->string('name',100);
            $table->string('description',255);
            $table->string('criteria',255);
            $table->string('image_remote',255);

            $table->integer('issuer_id')->unsigned();
            $table->foreign('issuer_id')->references('id')->on('issuers');

            $table->unique(array('version', 'name', 'description', 'criteria', 'image_remote', 'issuer_id'),'badges_all_unique');

            $table->string('image_local',255)->default("");

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_badge', function(Blueprint $table)
        {
            $table->integer('user_id')->unsigned();
            $table->integer('badge_id')->unsigned();
            $table->boolean('public')->default(false);
            $table->boolean('accepted')->default(false);

            $table->string('recipient', 255)->nullable();
            $table->string('salt', 255)->nullable();

            $table->string('notes')->default("");

            $table->primary(array('user_id','badge_id'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');

            $table->timestamp("issued_on");
            $table->timestamp('added_on');
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
        Schema::dropIfExists('user_badge');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('issuers');



	}

}
