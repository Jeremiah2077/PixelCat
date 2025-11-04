<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'file_path',
        'thumbnail_path',
        'original_name',
        'file_size',
        'mime_type',
        'width',
        'height',
        'order',
        'download_count',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : $this->url;
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
        $this->project->incrementDownloadCount();
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
