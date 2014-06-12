<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialItemsTable extends Migration {

	public function up()
	{
		Schema::create('social_items', function(Blueprint $table)
		{
			$table->increments('id');
		    $table->enum('type', ['twitter', 'instagram', 'facebook'])->index();
		    $table->string('type_id', 128);
		    $table->integer('user_id')->unsigned()->index();
		    $table->string('url');
		    $table->string('title')->nullable();
		    $table->text('content')->nullable();
		    $table->string('user_name');
		    $table->string('user_icon')->nullable();
		    $table->string('media')->nullable();
		    $table->string('media_thumb')->nullable();
		    $table->enum('media_type', ['image', 'video'])->nullable();
		    $table->mediumInteger('favorites')->unsigned()->default(0);
		    $table->timestamp('feeded_at')->nullable();
		    $table->nullableTimestamps();
		    $table->softDeletes();

		    $table->engine = 'InnoDB';
		});
	}

	public function down()
	{
		Schema::drop('social_items');
	}

}
