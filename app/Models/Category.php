<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'name'
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected function name()
    {
        return Attribute::make(
            set: fn ($value) => Str::kebab($value),
            get: fn ($value) => $value
        );
    }
}
