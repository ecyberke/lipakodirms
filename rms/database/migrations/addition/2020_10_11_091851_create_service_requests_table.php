<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->references('full_name')->on('tenants')->onUpdate('cascade');           
            $table->string('property')->references('name')->on('apartments')->onUpdate('cascade');
            $table->string('house_no')->references('house_no')->on('houses')->onUpdate('cascade');
            $table->string('service_request');
            $table->string('requested_date');
            $table->string('status');
            $table->float('amount');
            $table->string('pay_status');
            $table->string('attachment');

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
        Schema::dropIfExists('service_requests');
    }
}
