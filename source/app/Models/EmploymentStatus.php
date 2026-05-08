<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentStatus extends Model
{
    protected $fillable = [
        'name',
    ];

    public function personils(): HasMany
    {
        return $this->hasMany(Personil::class);
    }
}
