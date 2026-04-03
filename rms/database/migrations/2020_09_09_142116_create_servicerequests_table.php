<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicerequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicerequests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id');
            $table->string('tenant_name');
            $table->string('agent_name');
            $table->string('description');
            $table->string('status');
            $table->string('request_date');
            $table->timestamps();

            $table->foreign('tenant_id')
            ->references('id')->on('tenants')
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
        Schema::dropIfExists('servicerequests');
    }
}
