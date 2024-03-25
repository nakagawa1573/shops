<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'product_id',
        'date',
        'time',
        'number',
        'pay',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeSearchKeyword($query, $keyword)
    {
        $query->where('id', $keyword)
            ->orWhere('date', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%');
            });
    }
}
