<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category_id',
        'price',
        'product_stock',
        'status',
        'picture',
    ];

    // Accessor to calculate price with 11% PPN
    // public function getPriceAttribute($value)
    // {
    //     // Calculate price with 11% PPN
    //     return $value * 1.11;
    // }

    // Accessor to get readable status
    public function getStatusAttribute($value)
    {
        return $value === 'available' ? 'Available' : 'Not Available';
    }

    // Relation to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
