<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationClass;
use App\Mail\MailClass;
use App\Models\Blog;
use App\Models\Events;
use App\Models\News;
use App\Models\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        ],200);
    }

    public function appointment(Request $request){
        // throw new \Exception($request->name);
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'residence' => 'required|string',
            'service' => 'required|string',
            'time' => 'required',
            'date' => 'required|date',
            'date_of_birth' => 'required|date',
        ]);
        // throw new \Exception();
        Mail::to('deniswanjohi15@gmail.com')->send(new MailClass(
            $validate['name'],
            $validate['email'],
            $validate['phone'],
            $validate['residence'],
            $validate['date'],
            $validate['time'],
            $validate['service'],
        ));
        Mail::to('slightlightss@gmail.com')->send(new ConfirmationClass(
            $validate['name'],
            $validate['date'],
            $validate['time'],
            $validate['service'],
        ));
        return response('wahala');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Frontend $frontend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Frontend $frontend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Frontend $frontend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Frontend $frontend)
    {
        //
    }
}
