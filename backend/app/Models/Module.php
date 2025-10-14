<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_id',
        'name',
        'code',
        'icon',
    ];

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function submodules(): HasMany
    {
        return $this->hasMany(Submodule::class);
    }
}