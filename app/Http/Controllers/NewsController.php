<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class NewsController extends Controller
{
    //
    function create(Request $request){
        // dd(request()->hasFile('banner'));
        $validated = $request->validate([
            'title' => 'required | string',
            'subtitle' => 'required',
            'content' => 'required',
            'banner' => 'required',
        ]);

        if(request()->hasFile('banner')){
            $image = $request->file('banner');

            $imageName = time().'.'. $image->getClientOriginalExtension();

            $savedImg = $image->move('uploads',$imageName);
        
            $imageManager = new ImageManager(new  Driver());

            $thumbImage = $imageManager->read($savedImg->getPathname());
            
            $thumbImage->resize(300,300);

            $thumbnailName = pathinfo($imageName, PATHINFO_FILENAME) . '_thumb.' . $image->getClientOriginalExtension();
   
            $thumbImage->save(storage_path('app/public/news/'.$thumbnailName));

            $thumbnailPath = asset('storage/news/' . $thumbnailName);
            
            $validated['banner'] = $thumbnailPath;

            unlink(public_path($savedImg->getPathname()));
        }
        
       News::create($validated);
        
        return redirect('/dashboard');
    }

    function delete(Request $request){
        $banner = News::where('title','like',$request['title'])
            ->where('content','like',$request['content'])
            ->where('banner','like',$request['image'])
            ->pluck('banner');

        $banner = rtrim(basename($banner),'"]');

        $news = News::where('title','like',$request['title'])
            ->where('content','like',$request['content'])
            ->where('banner','like',$request['image'])
            ->delete();
        
        if($news === 1){
            unlink(public_path('storage/news/'.$banner));
            return redirect('/dashboard');
        }

    }

    function edit (Request $request ,$id){
        return  Inertia::render('Edit/News',[
            'data' => News::where('id','like',$id)->get(),
        ]);
    }

    function update(Request $request){
        $validated = $request->validate([
            'title' => 'required | string',
            'subtitle' => 'required',
            'content' => 'required',
            'banner' => 'required',  
        ]);

        $news = News::find($request->id);

        if ($news->exists) {
            // news post with ID 1 exists, update it
            $news->title = $validated['title'];
            $news->subtitle = $validated['subtitle'];
            $news->content = $validated['content'];
            // dd($validated);
            if(request()->hasFile('banner')){
                $image = $request->file('banner');

                $imageName = time().'.'. $image->getClientOriginalExtension();
    
                $savedImg = $image->move('uploads',$imageName);
            
                $imageManager = new ImageManager(new  Driver());
    
                $thumbImage = $imageManager->read($savedImg->getPathname());
                
                $thumbImage->resize(300,300);
    
                $thumbnailName = pathinfo($imageName, PATHINFO_FILENAME) . '_thumb.' . $image->getClientOriginalExtension();
       
                $thumbImage->save(storage_path('app/public/news/'.$thumbnailName));
    
                $thumbnailPath = asset('storage/news/' . $thumbnailName);
                
                $news->banner = $thumbnailPath;
    
                unlink(public_path($savedImg->getPathname()));
                
            }else{
                $news->banner = $validated['banner'];
            }
            $news->save();
        } else {
            // news post with ID 1 does not exist, create a new one
            $news->title = $validated['title'];
            $news->title = $validated['subtitle'];
            $news->title = $validated['content'];
            if(request()->hasFile('banner')){
                $path = request()->file('banner')->store('news','public');
                $validated['banner'] = $path;
            }
            $news->save();
        }

        return redirect('/dashboard');   
    }
}
