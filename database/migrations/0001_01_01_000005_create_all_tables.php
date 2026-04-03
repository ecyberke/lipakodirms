<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // House tenants (allocation records)
        Schema::create('house_tenants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id');
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade');
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade')->onUpdate('cascade');
        });

        // Rents
        Schema::create('rents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->float('amount');
            $table->decimal('electricity_bill', 15, 2)->default(0);
            $table->decimal('water_bill', 15, 2)->default(0);
            $table->decimal('litter_bill', 15, 2)->default(0);
            $table->decimal('compound_bill', 15, 2)->default(0);
            $table->decimal('security', 15, 2)->default(0);
            $table->decimal('others', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade')->onUpdate('cascade');
        });

        // Deposits
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->string('tenant_id');
            $table->float('amount');
            $table->decimal('electricity_bill', 15, 2)->default(0);
            $table->decimal('water_bill', 15, 2)->default(0);
            $table->decimal('litter_bill', 15, 2)->default(0);
            $table->decimal('compound_bill', 15, 2)->default(0);
            $table->decimal('security', 15, 2)->default(0);
            $table->decimal('others', 15, 2)->default(0);
            $table->string('start_month');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null')->onUpdate('cascade');
        });

        // Placement fees
        Schema::create('placement_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id');
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->float('amount');
            $table->decimal('electricity_bill', 15, 2)->default(0);
            $table->decimal('water_bill', 15, 2)->default(0);
            $table->decimal('litter_bill', 15, 2)->default(0);
            $table->decimal('compound_bill', 15, 2)->default(0);
            $table->decimal('security', 15, 2)->default(0);
            $table->decimal('others', 15, 2)->default(0);
            $table->string('placement_month');
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('houses')->onUpdate('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onUpdate('cascade')->onDelete('set null');
        });

        // Monthly billings
        Schema::create('monthly_billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('billing_name');
            $table->float('billing_amount');
            $table->string('billing_month')->index();
            $table->unsignedBigInteger('house_id');
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('houses')->onUpdate('cascade')->onDelete('cascade');
        });

        // Invoices
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
            $table->string('type')->nullable();
            $table->string('tenant_name')->nullable();
            $table->string('tenant_phone')->nullable();
            $table->string('apartment_name')->nullable();
            $table->string('house_name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('tenant_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('houses')->onUpdate('cascade');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onUpdate('cascade');
        });

        // Overpayments
        Schema::create('overpayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id');
            $table->float('amount');
            $table->decimal('electricity_bill', 15, 2)->default(0);
            $table->decimal('water_bill', 15, 2)->default(0);
            $table->decimal('litter_bill', 15, 2)->default(0);
            $table->decimal('compound_bill', 15, 2)->default(0);
            $table->decimal('security', 15, 2)->default(0);
            $table->decimal('others', 15, 2)->default(0);
            $table->timestamps();
        });

        // Overpaids
        Schema::create('overpaids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id')->index();
            $table->unsignedBigInteger('house_id')->index();
            $table->float('amount')->default(0);
            $table->timestamps();
        });

        // Viewing fees
        Schema::create('viewing_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apartment_id');
            $table->string('agent_name');
            $table->string('tenant_name');
            $table->string('phone_number');
            $table->decimal('viewing_amount', 15, 2);
            $table->timestamps();

            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade')->onUpdate('cascade');
        });

        // Service requests
        Schema::create('service_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id');
            $table->string('tenant_name');
            $table->string('agent_name')->nullable();
            $table->string('description');
            $table->string('status');
            $table->string('request_date');
            $table->integer('approval')->default(0);
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->float('amount')->nullable();
            $table->string('pay_status')->nullable();
            $table->string('attachment')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade')->onUpdate('cascade');
        });

        // Expenses (service request expenses)
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request_id');
            $table->decimal('amount_spent', 15, 2);
            $table->string('service_rendered');
            $table->string('status');
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('service_requests')->onDelete('cascade')->onUpdate('cascade');
        });

        // Agency expenses
        Schema::create('agency_expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_agent')->nullable();
            $table->string('description')->nullable();
            $table->string('phone_number')->nullable();
            $table->decimal('amount_spent', 15, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('files')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->unsignedBigInteger('landlord_id')->nullable();
            $table->string('expense_type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Pay owners (rent collection per apartment)
        Schema::create('pay_owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('landlord_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('bill_type')->nullable();
            $table->float('total_payable')->default(0);
            $table->float('paid_in')->default(0);
            $table->float('balance')->default(0);
            $table->integer('pay_status')->default(0);
            $table->string('rent_month')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Manual payments (M-Pesa STK push)
        Schema::create('manual_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TransactionType')->nullable();
            $table->string('MSISDN')->nullable();
            $table->string('TransID')->nullable();
            $table->string('TransAmount')->nullable();
            $table->string('InvoiceNumber')->nullable();
            $table->string('full_name')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('Manager')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Manager payments (pending tenant payments)
        Schema::create('manager_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TransactionType')->nullable();
            $table->string('MSISDN')->nullable();
            $table->string('TransID')->nullable();
            $table->string('TransAmount')->nullable();
            $table->string('InvoiceNumber')->nullable();
            $table->string('full_name')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('Manager')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Bill payments (approved bill payments)
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TransactionType')->nullable();
            $table->string('MSISDN')->nullable();
            $table->string('TransID')->nullable();
            $table->string('TransAmount')->nullable();
            $table->string('InvoiceNumber')->nullable();
            $table->string('full_name')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('service_provider')->nullable();
            $table->string('bill_for')->nullable();
            $table->timestamps();
        });

        // Bill manager payments (pending bill payments)
        Schema::create('bill_manager_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TransactionType')->nullable();
            $table->string('MSISDN')->nullable();
            $table->string('TransID')->nullable();
            $table->string('TransAmount')->nullable();
            $table->string('InvoiceNumber')->nullable();
            $table->string('full_name')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('Manager')->nullable();
            $table->string('service_provider')->nullable();
            $table->string('bill_for')->nullable();
            $table->string('bill_type')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        // Bills
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('landlord_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('bill_name')->nullable();
            $table->float('bill_amount')->default(0);
            $table->float('paid_in')->default(0);
            $table->float('balance')->default(0);
            $table->string('bill_month')->nullable();
            $table->integer('status')->default(0);
            $table->string('bill_type')->nullable();
            $table->timestamps();
        });

        // Incomes
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source')->nullable();
            $table->float('amount')->default(0);
            $table->string('description')->nullable();
            $table->string('income_month')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('landlord_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->timestamps();
        });

        // Manual invoices
        Schema::create('manual_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('landlord_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->string('type')->nullable();
            $table->float('total_payable')->default(0);
            $table->float('paid_in')->default(0);
            $table->float('balance')->default(0);
            $table->string('rent_month')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        // File manager
        Schema::create('file_manager', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename')->nullable();
            $table->string('file_type')->nullable();
            $table->string('related_id')->nullable();
            $table->string('related_type')->nullable();
            $table->timestamps();
        });

        // SMS
        Schema::create('sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('type')->nullable();
            $table->mediumText('message_body')->nullable();
            $table->integer('message_count')->default(0);
            $table->string('phone')->nullable();
            $table->string('status')->nullable();
            $table->string('tenant_id')->nullable();
            $table->timestamps();
        });

        // Logs
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->nullable();
            $table->mediumText('operation')->nullable();
            $table->mediumText('more_info')->nullable();
            $table->string('tenant_id')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('landlord_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('sms_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('servicerequest_id')->nullable();
            $table->timestamps();
        });

        // Messages
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->boolean('is_important')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        // Replies
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('message_id')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });

        // Demos
        Schema::create('demos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // House views
        Schema::create('house_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->string('viewing_date')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Owner invoices
        Schema::create('owner_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('landlord_id')->nullable();
            $table->string('owner_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->float('total_payable')->default(0);
            $table->float('paid_in')->default(0);
            $table->float('balance')->default(0);
            $table->string('rent_month')->nullable();
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        // Receipts
        Schema::create('receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->float('amount')->default(0);
            $table->string('payment_method')->nullable();
            $table->string('reference')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Repairs
        Schema::create('repairs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('description')->nullable();
            $table->decimal('cost', 15, 2)->default(0);
            $table->string('status')->nullable();
            $table->string('repair_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Tenant bill payments
        Schema::create('tenant_bill_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->float('amount')->default(0);
            $table->string('payment_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Tenant bills
        Schema::create('tenant_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tenant_id')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->string('bill_name')->nullable();
            $table->float('amount')->default(0);
            $table->string('bill_month')->nullable();
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        // Reports
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('report_type')->nullable();
            $table->text('report_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('tenant_bills');
        Schema::dropIfExists('tenant_bill_payments');
        Schema::dropIfExists('repairs');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('owner_invoices');
        Schema::dropIfExists('house_views');
        Schema::dropIfExists('demos');
        Schema::dropIfExists('replies');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('sms');
        Schema::dropIfExists('file_manager');
        Schema::dropIfExists('manual_invoices');
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('bill_manager_payments');
        Schema::dropIfExists('bill_payments');
        Schema::dropIfExists('manager_payments');
        Schema::dropIfExists('manual_payments');
        Schema::dropIfExists('pay_owners');
        Schema::dropIfExists('agency_expenses');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('service_requests');
        Schema::dropIfExists('viewing_fees');
        Schema::dropIfExists('overpaids');
        Schema::dropIfExists('overpayments');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('monthly_billings');
        Schema::dropIfExists('placement_fees');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('rents');
        Schema::dropIfExists('house_tenants');
        Schema::dropIfExists('houses');
        Schema::dropIfExists('apartments');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('landlords');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
    }
};
