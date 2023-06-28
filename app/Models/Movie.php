<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }


}
