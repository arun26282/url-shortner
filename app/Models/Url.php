<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'url', 'url_code'];

    /**
     * Get the user that owns the URL.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
