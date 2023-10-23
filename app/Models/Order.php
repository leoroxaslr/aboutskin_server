<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\product;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "cart_id",
        "status",
        "payment_type",
        "total",
        "order_id"
    ];
    protected $casts = [
        "created_at" => "date:Y-m-d H:i:s"
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
