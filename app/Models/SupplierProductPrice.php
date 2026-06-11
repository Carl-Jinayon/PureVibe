<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'cost_price',
        'selling_price',
        'markup_percentage',
        'reason',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'cost_price'        => 'decimal:2',
            'selling_price'     => 'decimal:2',
            'markup_percentage' => 'decimal:2',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
