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
        "product_id",
        "quantity", 
        "status",
        "payment_type",
        "total",
        "order_id",
        'weight',
        'length',
        'width',
        'height',
        'item_type',
        'phone_number',
        'postal_code',
        'customer_name',
        'customer_order_number',
    
    ];
    protected $casts = [
        "created_at" => "date:Y-m-d H:i:s"
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
