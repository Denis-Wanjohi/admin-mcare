<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Commentable;
use App\Models\Comments;
use App\Models\Events;
use App\Models\News;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //

    function create(Request $request){
        // throw new \Exception(json_encode(request('data')['name']));
        $validate = request()->validate([
            'data.name' => 'required',
            'data.comment' => 'required'
        ]);
        // throw new \Exception(json_encode($validate['data']['name']));
        $comment = Comments::create([
            'name' => $validate['data']['name'],
            'comment' => $validate['data']['comment'],
        ]);
        // throw new \Exception($comment['id']);
        Commentable::create([
            'comment_id' => $comment['id'],
            'commentable_type' => request('data')['commentable_type'],
            'commentable_id' =>  request('data')['commentable_id']
        ]);
        $blogs = Blog::with('comments')->orderBy('created_at','desc')->get()->map(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'subtitle' => $blog->subtitle,
                'content' => $blog->content,
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
        });
        $news = News::orderBy('created_at','desc')->get()->map(function($news){
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
        });

        $events = Events::orderBy('created_at','desc')->get()->map(function($events){
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
        });
        return response()->json([
            'blogs' => $blogs,
            'news' => $news,
            'events' => $events,
        ],200);;
    }

    function delete(Request $request){
        // $comment = Comments::find($request->data);
        // dd($request->id);
        $res = Comments::find($request->id);

        if ($res) {
            $res->delete();
   
            return back()->with('one','one' );
        } else {
            return response()->json(['error' => 'Comment not found.'], 404);  // Return error if comment not found
        }
        
    }
}
