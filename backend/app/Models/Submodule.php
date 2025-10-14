<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Submodule extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'name',
        'code',
        'route',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_submodule')
            ->withTimestamps()
            ->withPivot('granted_at', 'created_by');
    }
}