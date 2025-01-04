<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $primaryKey = 'purchase_id';
    protected $fillable = ['supplier_id', 'total_amount', 'purchase_date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id','supplier_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id','purchase_id');
    }
}

