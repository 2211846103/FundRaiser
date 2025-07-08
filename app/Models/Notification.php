<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const UPDATED_AT = null;
    protected $fillable = [
        'notif_type',
        'project_id',
        'comment_id',
        'user_id',
        'read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
