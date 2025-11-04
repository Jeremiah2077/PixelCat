<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'ip_address',
        'user_agent',
        'accessed_at',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
