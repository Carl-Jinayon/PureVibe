<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add cost_price and markup_percentage to products
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->after('unit_price')
                  ->comment('Supplier cost price for this product');
            $table->decimal('markup_percentage', 5, 2)->nullable()->after('cost_price')
                  ->comment('Per-product markup override. NULL = use global setting.');
        });

        // 2. Create supplier_product_price_history table
        Schema::create('supplier_product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('cost_price', 10, 2)->comment('Price supplier charges us');
            $table->decimal('selling_price', 10, 2)->comment('Calculated selling price at time of recording');
            $table->decimal('markup_percentage', 5, 2)->comment('Markup % applied at time of recording');
            $table->string('reason')->nullable()->comment('Reason for price change');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // 3. Add default_markup_percentage setting if not exists
        DB::table('settings')->insertOrIgnore([
            'key'        => 'default_markup_percentage',
            'value'      => '20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_product_prices');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'markup_percentage']);
        });

        DB::table('settings')->where('key', 'default_markup_percentage')->delete();
    }
};
