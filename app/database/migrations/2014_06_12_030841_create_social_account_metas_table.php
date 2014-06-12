<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountMetasTable extends Migration {

	public function up()
	{
		Schema::create('social_account_metas', function(Blueprint $table)
		{
			$table->increments('id');
		    $table->integer('account_id')->unsigned()->index();
		    $table->enum('type', ['twitter', 'instagram', 'facebook'])->index();
		    $table->string('key');
		    $table->string('value')->nullable();

		    $table->engine = 'InnoDB';
		});
	}

	public function down()
	{
		Schema::drop('social_account_metas');
	}

}
