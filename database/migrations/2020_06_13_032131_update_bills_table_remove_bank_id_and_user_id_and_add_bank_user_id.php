<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBillsTableRemoveBankIdAndUserIdAndAddBankUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
           $table->dropIndex('bills_user_id_bank_id_index');
           $table->dropColumn('bank_id');
           $table->dropColumn('user_id');

           $table->integer('bank_user_id')->unsigned();
           $table->foreign('bank_user_id')->references('id')->on('bank_users');
           $table->index('bank_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropIndex('bills_bank_user_id_index');
            $table->dropColumn('bank_user_id');
        });
    }
}
