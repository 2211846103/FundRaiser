<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const UPDATED_AT = null;
    protected $fillable = [
        'user_id',
        'project_id',
        'reason',
        'is_resolved',
        'resolve_date',
        'details'
    ];
    protected $casts = [
        'resolve_date' => 'date'
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
