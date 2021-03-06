<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    //User admin@admin.com
    //Pass $2y$10$HYosdWmZrDcTwn6a/hhLA.c9SowpQK1gkgbnO8Qwv9tSpRwbt8oAS -> Admin2710
    /**
     * INSERT INTO `users` 
     * (`name`, `email`,  `password`, `created_at`, `updated_at`) 
     *  VALUES 
     * ('admin', 'admin@admin.com', '$2y$10$HYosdWmZrDcTwn6a/hhLA.c9SowpQK1gkgbnO8Qwv9tSpRwbt8oAS', '2019-12-16 00:00:00', '2019-12-16 00:00:00');
     */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
