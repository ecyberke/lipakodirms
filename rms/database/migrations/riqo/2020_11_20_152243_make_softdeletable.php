<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSoftdeletable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('service_requests', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('landlords', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('houses', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('apartments', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tenants', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('pay_owners', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('landlords', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('houses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('pay_owners', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

    }
}
