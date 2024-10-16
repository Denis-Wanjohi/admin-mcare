<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = ['comment','category_id','category','name'];

    function blog(){
        return $this->belongsTo(Blog::class);
    }
    public function commentable()
    {
        // return $this->hasOne(Commentable::class);
        return $this->morphTo();
    }
}
