<?php

namespace App\Http\Controllers\Home;

use App\Models\HomeSlide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class HomeSliderController extends Controller
{
    // home slide
    public function homeSlider(){
        $homeslide = HomeSlide::find(1);
        return view('admin.homeSlide.homeSlideAll',compact('homeslide'));
    }// end method

    // update slide
    public function updateSlider(Request $request){
        $slide_id = $request->id;

        if($request->file('profileImage')){
            $image =$request->file('profileImage');
            $name_gen = hexdec(uniqid()). '.'.$image->getClientOriginalExtension(); // 132345.jpg

           Image::make($image)->resize(636,852)->save('upload/home_slide_images/'.$name_gen); // resize with image

            $save_url = 'upload/home_slide_images/'.$name_gen; // create image path

            // store in database
            HomeSlide::findorFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->shorttitle,
                'home_slide' => $save_url,
                'video_url' => $request->videourl,
            ]);
            $noti = [
                'message' => 'Home Slide Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($noti);
        }else{
              // store in database
              HomeSlide::findorFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->shorttitle,
                'video_url' => $request->videourl,
            ]);
            $noti = [
                'message' => 'Home Slide Updated without Image Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($noti);
        }// end else
    }// end method
}
