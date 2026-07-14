<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    protected $fillable = ['year'];
    use HasFactory;

    public function races(): HasMany
    {
        return $this->hasMany(Race::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }
}
