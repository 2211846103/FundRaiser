<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null;
    protected $fillable = [
        'admin_id',
        'action',
        'user_affected_id',
        'project_affected_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function affectedUser()
    {
        return $this->belongsTo(User::class, 'user_affected_id');
    }
    public function affectedProject()
    {
        return $this->belongsTo(Project::class, 'project_affected_id');
    }
}
