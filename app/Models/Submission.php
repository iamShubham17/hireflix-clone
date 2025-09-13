<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['interview_id', 'candidate_id', 'status'];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
