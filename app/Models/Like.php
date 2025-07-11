<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = ['user_id', 'project_id', 'comment_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
