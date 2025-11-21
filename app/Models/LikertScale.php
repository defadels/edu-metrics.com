<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LikertScale extends Model
{
    protected $fillable = [
        'name',
        'min_value',
        'max_value',
        'min_label',
        'max_label',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(LikertScaleOption::class, 'likert_scale_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'likert_scale_id');
    }
}
