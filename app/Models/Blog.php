<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title','subtitle','banner','content','category','comments'];

    function comments(){
        // return $this->hasManyThrough(Comments::class, Commentable::class);
        return $this->morphMany(Commentable::class,'commentable');
    }
}
