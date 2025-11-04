<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class PhotoTag extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'slug',
        'color',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'photo_photo_tag');
    }
}
