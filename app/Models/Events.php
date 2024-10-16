<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $fillable = ['title','subtitle','banner','content'];

    
    function comments(){
        return $this->hasManyThrough(Comments::class, Commentable::class);
    }
}
