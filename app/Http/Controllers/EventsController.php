<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EventsController extends Controller
{
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
   
            $thumbImage->save(storage_path('app/public/events/'.$thumbnailName));

            $thumbnailPath = asset('storage/events/' . $thumbnailName);
            
            $validated['banner'] = $thumbnailPath;

            unlink(public_path($savedImg->getPathname()));
        }

       Events::create($validated);
        
        return redirect('/dashboard');
    }

    function delete(Request $request){
        $banner = Events::where('title','like',$request['title'])
            ->where('content','like',$request['content'])
            ->where('banner','like',$request['image'])
            ->pluck('banner');
        $news = Events::where('title','like',$request['title'])
            ->where('content','like',$request['content'])
            ->where('banner','like',$request['image'])
            ->delete();

        $banner = rtrim(basename($banner),'"]');

        if($news === 1){
            unlink(public_path(path: 'storage/events/'.$banner));
            return redirect('/dashboard');
        }

    }

    function edit (Request $request ,$id){
        return  Inertia::render('Edit/Event',[
            'data' => Events::where('id','like',$id)->get(),
        ]);
    }

    function update(Request $request){
        // dd($request);
        $validated = $request->validate([
            'title' => 'required | string',
            'subtitle' => 'required',
            'content' => 'required',
            'banner' => 'required',  
        ]);

        
        $event = Events::find($request->id);

        if ($event->exists) {
            $event->title = $validated['title'];
            $event->subtitle = $validated['subtitle'];
            $event->content = $validated['content'];
            if(request()->hasFile('banner')){
                $image = $request->file('banner');

                $imageName = time().'.'. $image->getClientOriginalExtension();
    
                $savedImg = $image->move('uploads',$imageName);
            
                $imageManager = new ImageManager(new  Driver());
    
                $thumbImage = $imageManager->read($savedImg->getPathname());
                
                $thumbImage->resize(300,300);
    
                $thumbnailName = pathinfo($imageName, PATHINFO_FILENAME) . '_thumb.' . $image->getClientOriginalExtension();
       
                $thumbImage->save(storage_path('app/public/events/'.$thumbnailName));
    
                $thumbnailPath = asset('storage/events/' . $thumbnailName);
                
                $event->banner = $thumbnailPath;
    
                unlink(public_path($savedImg->getPathname()));
               
            }else{
                $event->banner = $validated['banner'];
            }
            $event->save();
        } else {
            // event post with ID 1 does not exist, create a new one
            $event->title = $validated['title'];
            $event->title = $validated['subtitle'];
            $event->title = $validated['content'];
            if(request()->hasFile('banner')){
                $path = request()->file('banner')->store('events','public');
                $validated['banner'] = $path;
            }
            $event->save();
        }

        return redirect('/dashboard');   
    }
}
