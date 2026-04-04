<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tables = [
            'users', 'tenants', 'landlords', 'apartments', 'houses',
            'house_tenants', 'invoices', 'manual_payments', 'manager_payments',
            'deposits', 'placement_fees', 'monthly_billings', 'overpayments',
            'overpaids', 'agency_expenses', 'pay_owners', 'service_requests',
            'service_providers', 'bill_categories', 'receipts', 'messages',
            'repairs', 'rents', 'expenses',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'org_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->unsignedBigInteger('org_id')->default(1)->after('id');
                    $t->index('org_id');
                });
            }
        }

        // Set existing data to org_id = 1 (demo organization)
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->whereNull('org_id')->orWhere('org_id', 0)->update(['org_id' => 1]);
            }
        }
    }

    public function down(): void {}
};
