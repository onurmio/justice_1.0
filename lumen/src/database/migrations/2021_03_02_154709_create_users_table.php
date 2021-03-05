<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();
            $table->string("phone", 11);
            $table->string("user_name", 32);
            $table->integer('groups');
            $table->integer('chat_tunnels');
            $table->boolean("activation")->default(0);

            #optional
            $table->boolean("private")->default(0);
            $table->boolean("invisible")->default(0);
            $table->string("login_key");
            $table->string("fcm_token");

            #settings
            $table->unique("phone");
            $table->unique("login_key");
            $table->unique("fcm_token");

            #informations
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
        Schema::dropIfExists("users");
    }
}
