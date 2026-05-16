<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['quote', 'name', 'role', 'initials', 'gradient', 'rating', 'is_active'];
}
