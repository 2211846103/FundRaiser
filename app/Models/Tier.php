<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'amount',
        'title',
        'desc'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
