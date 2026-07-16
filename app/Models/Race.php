<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Race extends Model
{
    use HasFactory;
     protected $fillable = ['season_id', 'circuit_id', 'round', 'name', 'date', 'time'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function circuit(): BelongsTo
    {
        return $this->belongsTo(Circuit::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class)->orderBy('position');
    }

    public function qualifyingResults(): HasMany
    {
        return $this->hasMany(QualifyingResult::class)->orderBy('position');
    }
}
