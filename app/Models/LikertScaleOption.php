<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LikertScaleOption extends Model
{
    protected $fillable = [
        'likert_scale_id',
        'value',
        'label',
        'order',
    ];

    public function likertScale(): BelongsTo
    {
        return $this->belongsTo(LikertScale::class, 'likert_scale_id');
    }
}
