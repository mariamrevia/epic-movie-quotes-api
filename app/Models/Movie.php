<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['name','director' ,'description' ];
    protected $guarded = ['id'];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? false, function ($query, $search) {
            $searchTerm = strtolower($search);
            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw("lower(json_extract(name, '$.en')) LIKE ?", ['%' . $searchTerm . '%'])
                    ->orWhereRaw("json_extract(name, '$.ka') LIKE ?", ['%' . $searchTerm . '%']);
            });

        });

    }


}
