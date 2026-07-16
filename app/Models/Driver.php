<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['ref', 'code', 'number', 'forename', 'surname', 'nationality', 'dob'];

    protected function casts(): array
    {
        return ['dob' => 'date'];
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function qualifyingResults(): HasMany
    {
        return $this->hasMany(QualifyingResult::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::get(fn () => "{$this->forename} {$this->surname}");
    }
}
