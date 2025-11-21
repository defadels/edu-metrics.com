<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'is_anonymous',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_active' => 'boolean',
            'is_anonymous' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SurveyCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'survey_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class, 'survey_id');
    }
}
