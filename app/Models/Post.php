<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $user_id;
    protected $fillable = ['title', 'content', 'user_id', 'image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
