<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->string('tenant_id');
            $table->float('amount');
            $table->string('start_month');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('house_id')
                ->references('id')->on('houses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('apartment_id')
                ->references('id')->on('apartments')
                ->onDelete('set null')
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
        Schema::dropIfExists('deposits');
    }
}
