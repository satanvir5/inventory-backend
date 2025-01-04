<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $primaryKey = 'purchase_item_id';
    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'unit_price', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
