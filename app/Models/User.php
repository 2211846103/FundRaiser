<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'phone',
        'company_name',
        'is_banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'creator_id');
    }
    public function donations()
    {
        return $this->hasMany(Donation::class, 'backer_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'likes');
    }
    public function likedProjects()
    {
        return $this->belongsToMany(Project::class, 'likes');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function logs()
    {
        return $this->hasMany(AdminLog::class, 'admin_id');
    }
    public function affectedLogs()
    {
        return $this->hasMany(AdminLog::class, 'user_affected_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function notifyFunded(Project $project)
    {
        $notif = new \App\Models\Notification;
        $notif->notif_type = 'milestone';
        $notif->user_id = $this->id;
        $notif->comment_id = null;
        $notif->project_id = $project->id;
        $notif->save();
    }
    public function notifyReply(Comment $comment)
    {
        \App\Models\Notification::create([
            'notif_type' => 'reply',
            'user_id' => $this->id,
            'comment_id' => $comment->id,
            'project_id' => null
        ]);
    }
    public function notifyFail(Project $project)
    {
        $notif = new \App\Models\Notification;
        $notif->notif_type = 'fail';
        $notif->user_id = $this->id;
        $notif->comment_id = null;
        $notif->project_id = $project->id;
        $notif->save();
    }
    public function notifyWelcome()
    {
        $notif = new \App\Models\Notification;
        $notif->notif_type = 'welcome';
        $notif->user_id = $this->id;
        $notif->comment_id = null;
        $notif->project_id = null;
        $notif->save();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
