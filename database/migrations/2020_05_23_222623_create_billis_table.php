<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->timestamp('date');
            $table->float('value');
            $table->forieng('bank_id');
            $table->forieng('user_id');
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
        Schema::dropIfExists('billis');
    }
}
