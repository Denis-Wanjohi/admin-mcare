<?php

namespace App\Http\Controllers;

// use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Blog;
use App\Models\Commentable;
use App\Models\Comments;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    //

    function create(Request $request){
        // dd(request()->file('banner'));
        $validated = $request->validate([
            'title' => 'required | string',
            'subtitle' => 'required',
            'content' => 'required',
            'banner' => 'required',
            'category' => 'required',
        ]);

        if(request()->hasFile('banner')){
            $image = $request->file('banner');

            $imageName = time().'.'. $image->getClientOriginalExtension();

            $savedImg = $image->move('uploads',$imageName);
        
            $imageManager = new ImageManager(new  Driver());

            $thumbImage = $imageManager->read($savedImg->getPathname());
            
            $thumbImage->resize(300,300);

            $thumbnailName = pathinfo($imageName, PATHINFO_FILENAME) . '_thumb.' . $image->getClientOriginalExtension();
   
            $thumbImage->save(storage_path('app/public/blogs/'.$thumbnailName));

            $thumbnailPath = asset('storage/blogs/' . $thumbnailName);
            
            $validated['banner'] = $thumbnailPath;

            unlink(public_path($savedImg->getPathname()));
        }
        
       Blog::create($validated);
        

        return redirect('/dashboard');
    }

    function delete(Request $request){
        $banner = Blog::where('title','like',$request['title'])
                ->where('content','like',$request['content'])
                ->where('banner','like',$request['image'])
                ->pluck('banner');
        $id = Blog::where('title','like',$request['title'])
                ->where('content','like',$request['content'])
                ->where('banner','like',$request['image'])
                ->pluck('id');


        $banner = rtrim(basename($banner),'"]');
        
        $news = Blog::where('title','like',$request['title'])
            ->where('content','like',$request['content'])
            ->where('banner','like',$request['image'])
            ->delete();
        
        if($news === 1){
            unlink(public_path('storage/blogs/'.$banner));
            $commentable = Commentable::where('commentable_id','like',$id)->get();
            foreach ($commentable as $comment) {
                Comments::where('id','like',$comment['comment_id'])->delete();
            }
            return redirect('/dashboard');
        }else{
            return back()->with('error', 'No matching record found to delete.');
        }

    }

    function edit (Request $request ,$id){
        // dd($request);
        return  Inertia::render('Edit/Blog',[
            'data' => Blog::where('id','like',$id)->get(),
        ]);
    }

    function update(Request $request){
        // dd($request);
        $validated = $request->validate([
            'title' => 'required | string',
            'subtitle' => 'required',
            'content' => 'required',
            'banner' => 'required',  
            'category' => 'required',
        ]);
        
        $blog = Blog::find($request->id);

        if ($blog->exists) {
            $blog->title = $validated['title'];
            $blog->subtitle = $validated['subtitle'];
            $blog->content = $validated['content'];
            $blog->category = $validated['category'];
            // dd($validated);
            if(request()->hasFile('banner')){
                $image = $request->file('banner');

                $imageName = time().'.'. $image->getClientOriginalExtension();
    
                $savedImg = $image->move('uploads',$imageName);
            
                $imageManager = new ImageManager(new  Driver());
    
                $thumbImage = $imageManager->read($savedImg->getPathname());
                
                $thumbImage->resize(300,300);
    
                $thumbnailName = pathinfo($imageName, PATHINFO_FILENAME) . '_thumb.' . $image->getClientOriginalExtension();
       
                $thumbImage->save(storage_path('app/public/blogs/'.$thumbnailName));
    
                $thumbnailPath = asset('storage/blogs/' . $thumbnailName);
                
                $blog->banner = $thumbnailPath;

                unlink(public_path($savedImg->getPathname()));
                
            }else{
                $blog->banner = $validated['banner'];
            }
            $blog->save();
        } else {
            // Blog post with ID 1 does not exist, create a new one
            $blog->title = $validated['title'];
            $blog->title = $validated['subtitle'];
            $blog->title = $validated['content'];
            $blog->title = $validated['category'];
            if(request()->hasFile('banner')){
                $path = request()->file('banner')->store('blogs','public');
                $validated['banner'] = $path;
            }
            $blog->save();
        }

        return redirect('/dashboard');   
    }
}
