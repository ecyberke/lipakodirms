<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('billing_name');
            $table->float('billing_amount');
            $table->string('billing_month')->index();
            $table->unsignedBigInteger('house_id');
            $table->timestamps();

            $table->foreign('house_id')
                ->references('id')->on('houses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_billings');
    }
}
