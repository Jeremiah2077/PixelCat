<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'photographer_id',
        'title',
        'project_date',
        'location',
        'client_name',
        'notes',
        'status',
        'share_token',
        'allow_download',
        'view_count',
        'download_count',
    ];

    protected $casts = [
        'project_date' => 'date',
        'allow_download' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->share_token)) {
                $project->share_token = Str::random(32);
            }
        });
    }

    public function photographer(): BelongsTo
    {
        return $this->belongsTo(Photographer::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('order');
    }

    public function photoGroups(): HasMany
    {
        return $this->hasMany(PhotoGroup::class)->orderBy('sort_order');
    }

    public function photoTags(): HasMany
    {
        return $this->hasMany(PhotoTag::class);
    }

    public function favoritePhotos(): HasMany
    {
        return $this->hasMany(Photo::class)->where('is_favorite', true);
    }

    public function accesses(): HasMany
    {
        return $this->hasMany(ProjectAccess::class);
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    public function getShareUrlAttribute(): string
    {
        return route('gallery.show', $this->share_token);
    }

    public function getRecentAccessesCount(): int
    {
        return $this->accesses()
            ->where('accessed_at', '>=', now()->subDays(7))
            ->count();
    }
}
