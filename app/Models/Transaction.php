<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'transaction_year',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
