<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('description',200)->nullable();;
            $table->string('issue_no',50)->nullable();;
            $table->string('reject_reason',200)->nullable();
            $table->string('solution',200)->nullable();;
            $table->integer('rejected_by')->nullable();;
            $table->dateTime('rejected_at')->nullable();;
            $table->dateTime('approved_at')->nullable();;
            $table->integer('approved_by')->nullable();;
            $table->integer('assigned_to')->nullable();;
            $table->dateTime('assigned_at')->nullable();;
            $table->integer('created_department_id')->nullable();;
            $table->integer('rectify_department_id')->nullable();;
            $table->integer('status')->nullable();;
            $table->integer('issue_type')->nullable();;
            $table->integer('created_by')->nullable();;
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
        Schema::dropIfExists('issue');
    }
}
