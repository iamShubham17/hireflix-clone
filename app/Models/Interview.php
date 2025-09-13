<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'created_by', 'status'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}