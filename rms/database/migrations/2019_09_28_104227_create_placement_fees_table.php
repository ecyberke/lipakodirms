<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacementFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placement_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id');
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->float('amount');
            $table->string('placement_month');
            $table->timestamps();

            $table->foreign('house_id')
                ->references('id')->on('houses')
                ->onUpdate('cascade');

            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onUpdate('cascade');

            $table->foreign('apartment_id')
                ->references('id')->on('apartments')
                ->onUpdate('cascade')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('placement_fees');
    }
}
