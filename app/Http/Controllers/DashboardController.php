<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Events;
use App\Models\News;
use App\Models\Comments;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return response([
            'blogs'=>        $blogs = Blog::with('comments')->orderBy('created_at','desc')->get()->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'subtitle' => $blog->subtitle,
                    'content' => $blog->content,
                    'category' => $blog->category,
                    'comments' => $blog->comments->map(function ($comment) {
                        return [
                            'id' => $comment->id,
                            'comment' => $comment->comment,
                            'name' => $comment->name,
                        ];
                    }),
                    'banner' => $blog->banner,
                    'created_at' => $blog->created_at
                ];
            }),
            'news' => News::orderBy('created_at','desc')->get()->map(function($news){
                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'subtitle' => $news->subtitle,
                    'banner' => $news->banner,
                    'content' => $news->content,
                    'created_at' => $news->created_at,
                    'updated_at' => $news->updated_at,
                    'type' => 'news',
                ];
            }), 
            'events' => $events = Events::orderBy('created_at','desc')->get()->map(function($events){
                return [
                    'id' => $events->id,
                    'title' => $events->title,
                    'subtitle' => $events->subtitle,
                    'banner' => $events->banner,
                    'content' => $events->content,
                    'created_at' => $events->created_at,
                    'updated_at' => $events->updated_at,
                    'type' => 'event',
                ];
            }),
            'comments' => Comments::orderBy('created_at','desc')->count(),
        ]);
    }
}
