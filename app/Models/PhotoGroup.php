<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PhotoGroup extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'sort_order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->name);
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}
