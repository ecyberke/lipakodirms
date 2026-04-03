<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('request_id');
                $table->decimal('amount_spent',15,2);
                $table->string('service_rendered');
                $table->string('status');
                $table->string('file');

                $table->timestamps();
    
                $table->foreign('request_id')
                ->references('id')->on('servicerequests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
