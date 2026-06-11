<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'supplier_id',
        'image',
        'sku',
        'barcode',
        'cost_price',
        'markup_percentage',
        'unit_price',
        'current_stock',
        'low_stock_threshold',
        'unit',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cost_price'        => 'decimal:2',
            'markup_percentage' => 'decimal:2',
            'unit_price'        => 'decimal:2',
            'current_stock'     => 'integer',
            'low_stock_threshold' => 'integer',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Calculate the selling price from cost + markup.
     * Falls back to the global setting if no per-product markup is set.
     *
     * @param float|null $costPrice      Override cost price (e.g. from a stock entry)
     * @param float|null $markupOverride Override markup % (e.g. per-product value)
     * @return float|null                NULL if no cost price is available
     */
    public function calculateSellingPrice(?float $costPrice = null, ?float $markupOverride = null): ?float
    {
        $cost   = $costPrice ?? (float) $this->cost_price;
        if ($cost <= 0) return null;

        $markup = $markupOverride
            ?? (float) ($this->markup_percentage
                ?? \App\Models\Setting::where('key', 'default_markup_percentage')->value('value')
                ?? 20);

        return round($cost * (1 + $markup / 100), 2);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include products with low stock.
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('current_stock', '<=', 'low_stock_threshold');
    }

    /**
     * Scope a query to only include products that are in stock.
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('current_stock', '>', 0);
    }

    /**
     * Check if the product has low stock.
     */
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->low_stock_threshold;
    }

    /**
     * Get the category this product belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the supplier this product belongs to.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the transaction items for this product.
     */
    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Get the inventory movements for this product.
     */
    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    /**
     * Alias for inventoryMovements for backwards compat.
     */
    public function movements(): HasMany
    {
        return $this->inventoryMovements();
    }

    /**
     * Accessor: map ->price to unit_price column.
     */
    public function getPriceAttribute(): mixed
    {
        return $this->unit_price;
    }

    /**
     * Get the supplier price history for this product.
     */
    public function supplierPriceHistory()
    {
        return $this->hasMany(SupplierProductPrice::class)->latest();
    }
}
