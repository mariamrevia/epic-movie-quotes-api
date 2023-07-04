<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Quote extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['body'];

    protected $guarded = ['id'];
    public function movie(): BelongsTo
    {

        return $this->belongsTo(Movie::class);

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                if (Str::startsWith($search, '@')) {
                    $searchTerm = strtolower(substr($search, 1));
                    $query->whereRaw("lower(json_extract(body, '$.en')) LIKE ?", ['%' . $searchTerm . '%'])
                    ->orWhereRaw("lower(json_extract(body, '$.ka')) LIKE ?", ['%' . $searchTerm . '%']);
                } elseif (Str::startsWith($search, '#')) {
                    $searchTerm = strtolower(substr($search, 1));
                    $query->orWhereHas('movie', function ($query) use ($searchTerm) {
                        $query->whereRaw("lower(json_extract(name, '$.en')) LIKE ?", ['%' . $searchTerm . '%'])
                    ->orWhereRaw("lower(json_extract(name, '$.ka')) LIKE ?", ['%' . $searchTerm . '%']);
                    });
                } else {
                    $searchTerm = strtolower($search);
                    $query->where(function ($query) use ($searchTerm) {
                        $query->whereRaw("lower(json_extract(body, '$.en')) LIKE ?", ['%' . $searchTerm . '%'])
                        ->orWhereRaw("lower(json_extract(name, '$.ka')) LIKE ?", ['%' . $searchTerm . '%'])
                            ->orWhereHas('movie', function ($query) use ($searchTerm) {
                                $query->whereRaw("lower(json_extract(name, '$.en')) LIKE ?", ['%' . $searchTerm . '%'])
                                ->whereRaw("lower(json_extract(name, '$.ka')) LIKE ?", ['%' . $searchTerm . '%']);
                            });
                    });
                }
            });
        });

    }
};
