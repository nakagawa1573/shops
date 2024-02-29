<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'shop',
        'overview',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

    public function genre()
    {
        return $this->belongsToMany(Genre::class);
    }
}
