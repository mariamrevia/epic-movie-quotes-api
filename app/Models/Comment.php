<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);

    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}