<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['Product', 'Price', 'Description', 'Branch', 'image'];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Branch', 'id');
    }
}
