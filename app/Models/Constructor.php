<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Constructor extends Model
{

    protected $fillable = ['ref', 'name', 'nationality'];

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

}
