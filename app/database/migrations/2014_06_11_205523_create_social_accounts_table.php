<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountsTable extends Migration {

    public function up()
    {
        Schema::create('social_accounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('twitter', 128)->nullable();
            $table->string('instagram', 128)->nullable();
            $table->string('facebook', 128)->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::drop('social_accounts');
    }

}
