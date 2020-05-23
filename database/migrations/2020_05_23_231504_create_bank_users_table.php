<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigend();
            $table->integer('bank_id')->unsigend();
            $table->float('balance');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('users')->on('id');
            $table->foreign('bank_id')->references('banks')->on('id');

            $table->index(['user_id', 'bank_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_users');
    }
}
