<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'cidade',
        'uf',
        'is_active',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
