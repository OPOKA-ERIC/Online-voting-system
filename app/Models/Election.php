<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'voters_file', 'unique_column', 'voters_data'];

    protected $casts = [
        'start_date'  => 'datetime',
        'end_date'    => 'datetime',
        'voters_data' => 'array',
    ];

    public function getStatusAttribute()
    {
        $now = now();
        if ($now < $this->start_date) return 'upcoming';
        if ($now > $this->end_date) return 'closed';
        return 'active';
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function voters()
    {
        return $this->hasMany(\App\Models\User::class)->where('role', 'voter');
    }
}
