<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'primary_color',
        'accent_color',
        'logo_url',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}