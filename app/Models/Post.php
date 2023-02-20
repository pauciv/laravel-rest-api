<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // definir qué columnas puedo rellenar de forma automática
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
