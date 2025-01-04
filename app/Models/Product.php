<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'SKU',
        'price',
        'initial_stock_quantity',
        'current_stock_quantity',
        'category_id',
    ];
}

