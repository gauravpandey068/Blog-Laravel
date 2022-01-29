<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'category', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function likedBy(User $user){
        return $this->likes->contains('user_id', $user->id); // check if user like post or not
    }
    public function commentBy(User $user){
        return $this->comments->contains('user_id', $user->id); // check if user comment on post or not
    }
}
