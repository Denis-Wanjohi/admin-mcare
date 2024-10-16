<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentable extends Model
{
    use HasFactory;

    public  $fillable = ['comment_id','commentable_type','commentable_id',];

    public function comment(){
        return $this->belongsTo(Comments::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function event()
    {
        return $this->belongsTo(Events::class);
    }
}
