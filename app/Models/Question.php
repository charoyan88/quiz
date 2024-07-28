<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{

    protected $guarded = [];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
    public function scopeNext($query, $currentId)
    {
        return $query->where('id', '>', $currentId)->orderBy('id', 'asc')->first();
    }

    public function scopePrevious($query, $currentId)
    {
        return $query->where('id', '<', $currentId)->orderBy('id', 'desc')->first();
    }
}
