<?php

namespace App\Models;

use App\Services\CountWordsService;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = [
        'word_count',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wordCount(): Attribute
    {
        return Attribute::make(
            get: fn () => (new CountWordsService())->count($this->content),
        )->shouldCache();
    }

    public function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price / 100, 2, ',', '.') . '€',
        );
    }
}
