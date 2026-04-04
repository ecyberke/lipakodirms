<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('units_min');
            $table->integer('units_max')->nullable(); // null = unlimited
            $table->decimal('price_per_unit', 10, 2); // monthly price per unit
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default pricing tiers
        DB::table('subscription_plans')->insert([
            ['name' => 'Starter', 'units_min' => 1, 'units_max' => 100, 'price_per_unit' => 150, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Growth', 'units_min' => 101, 'units_max' => 500, 'price_per_unit' => 120, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business', 'units_min' => 501, 'units_max' => 1000, 'price_per_unit' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Enterprise', 'units_min' => 1001, 'units_max' => null, 'price_per_unit' => 80, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('subscription_plans');
    }
};
