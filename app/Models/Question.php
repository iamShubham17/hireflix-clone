<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['interview_id', 'question_text', 'order', 'time_limit'];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}