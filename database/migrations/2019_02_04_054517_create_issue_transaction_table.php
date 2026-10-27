<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_transaction', function (Blueprint $table) {
             $table->increments('id');
            $table->string('transaction')->nullable();
            $table->string('description')->nullable();
            $table->string('transaction_no',50)->nullable();
            $table->string('type',50)->nullable();
            $table->string('color',50)->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('event_type')->nullable();
            $table->integer('reference_id')->nullable();
            $table->integer('status')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('issue_transaction');
    }
}
