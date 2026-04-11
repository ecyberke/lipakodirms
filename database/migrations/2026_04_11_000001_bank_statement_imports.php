<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_statement_imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('org_id');
            $table->string('bank_name');
            $table->string('filename');
            $table->string('account_number')->nullable();
            $table->date('statement_from')->nullable();
            $table->date('statement_to')->nullable();
            $table->decimal('total_credits', 15, 2)->default(0);
            $table->integer('row_count')->default(0);
            $table->integer('matched_count')->default(0);
            $table->integer('unmatched_count')->default(0);
            $table->string('imported_by')->nullable();
            $table->timestamps();

            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
        });

        Schema::table('manager_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('import_id')->nullable()->after('org_id');
            $table->foreign('import_id')->references('id')->on('bank_statement_imports')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('manager_payments', function (Blueprint $table) {
            $table->dropForeign(['import_id']);
            $table->dropColumn('import_id');
        });

        Schema::dropIfExists('bank_statement_imports');
    }
};
