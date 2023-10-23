<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_id",
        "user_id",
        "quantity",
        "price",
        "total_price"
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
