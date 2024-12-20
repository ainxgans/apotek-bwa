<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductTransaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'total_amount',
        'is_paid',
        'address',
        'city',
        'post_code',
        'phone_number',
        'notes',
        'proof',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected function casts(): array
    {
        return [
            'is_paid' => 'boolean',
        ];
    }
}
