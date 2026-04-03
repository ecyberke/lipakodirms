<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverpaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overpaids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');           
            $table->unsignedBigInteger('house_id')->references('id')->on('houses')->onUpdate('cascade');
            $table->float('amount')->default(0);
            $table->index('tenant_id');
            $table->index('house_id');
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
        Schema::dropIfExists('overpaids');
    }
}
