<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    /**
     * Get the users for the company.
     */
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all the URLs associated with the company through its users.
     */
    public function urls() : HasManyThrough
    {
        return $this->hasManyThrough(Url::class, User::class);
    }
}
