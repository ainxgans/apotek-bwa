<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_transaction_id',
        'product_id',
        'price',
    ];

    public function productTransaction(): BelongsTo
    {
        return $this->belongsTo(ProductTransaction::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
