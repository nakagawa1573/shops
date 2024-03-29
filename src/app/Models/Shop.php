<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'owner_id',
        'stripe_account',
        'shop',
        'overview',
        'img',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsToMany(Genre::class, 'shop_genres');
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function reservation()
    {
        return $this->belongsToMany(User::class, 'reservations')->withPivot('id', 'date', 'time', 'number');
    }

    public function evaluation()
    {
        return $this->belongsToMany(User::class, 'evaluations')->withPivot('evaluation');
    }

    public function scopeShopSearch($query, $keyword)
    {
        $query->where('shop', 'LIKE', '%' . $keyword . '%');
    }

    public function scopeAreaSearch($query, $area)
    {
        if ($area) {
            $query->where('area_id', $area);
        }
    }

    public function scopeGenreSearch($query, $genre)
    {
        if ($genre) {
            $query->whereHas('genre', function ($query) use ($genre) {
                $query->where('genre_id', $genre);
            });
        }
    }
}
