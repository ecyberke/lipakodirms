<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('rent')->nullable();
            $table->float('bills')->nullable();
            $table->float('overpayment')->nullable();
            $table->float('penalty_fee')->nullable();
            $table->float('carryforward')->nullable();
            $table->float('total_payable')->default(0);            
            $table->float('paid_in')->default(0);
            $table->float('balance')->default(0)->index();
            $table->string('rent_month')->index();
            $table->boolean('is_paid')->default(0);
            $table->string('payment_method')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('house_id')->references('id')->on('houses')->onUpdate('cascade');
            $table->unsignedBigInteger('apartment_id')->references('id')->on('apartments')->onUpdate('cascade');
            $table->string('tenant_id')->references('id')->on('tenants')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
