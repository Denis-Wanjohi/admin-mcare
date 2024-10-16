<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Models\Blog;
use App\Models\Events;
use App\Models\News;
use App\Models\Comments;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// Route::group(['prefix' => 'api/v1'], function () {
//     // Route::get('/users', 'UserController@apiGetUsers');
//     // Route::get('/data',[FrontendController::class,'index']);
//     Route::post('/comment',[CommentsController::class,'create']);
//     // Add more API endpoints here
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/blogUpload',[BlogController::class,'create']);
    Route::post('/eventUpload',[EventsController::class,'create']);
    Route::post('/newsUpload',[NewsController::class,'create']);

    Route::post('/deleteBlog',[BlogController::class,'delete']);
    Route::post('/deleteEvent',[EventsController::class,'delete']);
    Route::post('/deleteNews',[NewsController::class,'delete']);

    Route::get('/edit/blog/{blog}',[BlogController::class,'edit'])->name('edit.blog');
    Route::get('/edit/event/{id}',[EventsController::class,'edit']);
    Route::get('/edit/news/{id}',[NewsController::class,'edit']);

    Route::post('/blogUpdate',[BlogController::class,'update']);
    Route::post('/eventUpdate',[EventsController::class,'update']);
    Route::post('/newsUpdate',[NewsController::class,'update']);

    Route::post('/deleteComment',[CommentsController::class,'delete']);
});

require __DIR__.'/auth.php';
