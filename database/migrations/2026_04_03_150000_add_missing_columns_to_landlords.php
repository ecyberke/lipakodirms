<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landlords', function (Blueprint $table) {
            $table->string('landlordid_number')->nullable()->after('phone_no');
            $table->string('town')->nullable()->after('address');
            $table->string('country')->nullable()->after('town');
            $table->string('bank_name')->nullable()->after('country');
            $table->string('bank_branch')->nullable()->after('bank_name');
            $table->string('bank_acc_name')->nullable()->after('bank_branch');
            $table->string('bank_acc_no')->nullable()->after('bank_acc_name');
            $table->string('emergency_person')->nullable()->after('bank_acc_no');
            $table->string('emergency_id')->nullable()->after('emergency_person');
            $table->string('emergency_number')->nullable()->after('emergency_id');
            $table->string('relationship')->nullable()->after('emergency_number');
        });
    }

    public function down(): void
    {
        Schema::table('landlords', function (Blueprint $table) {
            $table->dropColumn([
                'landlordid_number', 'town', 'country',
                'bank_name', 'bank_branch', 'bank_acc_name', 'bank_acc_no',
                'emergency_person', 'emergency_id', 'emergency_number', 'relationship'
            ]);
        });
    }
};
