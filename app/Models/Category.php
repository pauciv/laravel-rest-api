<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // por defecto los modelos ya se crean con esta clase.

    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)
            ->orderBy('published_at', 'DESC');
    }
}
