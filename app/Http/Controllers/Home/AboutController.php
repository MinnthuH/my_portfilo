<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class AboutController extends Controller
{
    // about page
    public function aboutPage()
    {
        $aboutPage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutPage'));
    } // end method

    // update about page data
    public function UpdateAbout(Request $request)
    {
        $about_id = $request->id;

        if ($request->file('aboutImage')) {
            $image = $request->file('aboutImage');

            $name_gen =
                hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 132345.jpg

            Image::make($image)
                ->resize(523, 605)
                ->save('upload/about_images/' . $name_gen); // resize with image

            $save_url = 'upload/about_images/' . $name_gen; // create image path

            // store in database
            About::findorFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->shorttitle,
                'short_description' => $request->shortdescription,
                'long_description' => $request->longdescription,
                'about_image' => $save_url,
            ]);
            $noti = [
                'message' => 'About Page Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()
                ->back()
                ->with($noti);
        } else {
            // store in database
            About::findorFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->shorttitle,
                'short_description' => $request->shortdescription,
                'long_description' => $request->longdescription,
            ]);
            $noti = [
                'message' => 'About Page Updated without Image Successfully',
                'alert-type' => 'success',
            ];
            return redirect()
                ->back()
                ->with($noti);
        } // end else
    } // end method

    // home about page route for frontend
    public function homeAboutPage()
    {
        $aboutPage = About::find(1);
        return view('frontend.home_all.about_page', compact('aboutPage'));
    } //end method

    // about multiImage page route for backend
    public function aboutMulti()
    {
        return view('admin.about_page.multiImages');
    } // end method

    //  multi images store in database
    public function storeMulitImages(Request $request)
    {
        $image = $request->file('multiImages');

        foreach ($image as $multiImages) {
            $name_gen =
                hexdec(uniqid()) .
                '.' .
                $multiImages->getClientOriginalExtension(); // 132345.jpg

            Image::make($multiImages)
                ->resize(220, 220)
                ->save('upload/multiImages/' . $name_gen); // resize with image

            $save_url = 'upload/multiImages/' . $name_gen; // create image path

            // store in database
            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        } // end foreach
        $noti = [
            'message' => 'Multi Image Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($noti);
    } // end method

    // all multi image page backend
    public function allMultiImages()
    {
        $allMultiImages = MultiImage::all();
        return view(
            'admin.about_page.all_Multi_Image',
            compact('allMultiImages')
        );
    } // end method

    // edit multi image page
    public function editMultiImages($id)
    {
        $allMultiImage = MultiImage::findOrFail($id);
        return view(
            'admin.about_page.edit_multi_image',
            compact('allMultiImage')
        );
    } // end method

    // update multi image
    public function updateMultiImages(Request $request)
    {
        $multiImageId = $request->id;



        if ($request->file('multiImages')) {
            $image = $request->file('multiImages');

            $name_gen =
                hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 132345.jpg

            Image::make($image)
                ->resize(220, 220)
                ->save('upload/multiImages/' . $name_gen); // resize with image

            $save_url = 'upload/multiImages/' . $name_gen; // create image path


            // store in database
            MultiImage::findorFail($multiImageId)->update([
                'multi_image' => $save_url,
            ]);
            $noti = [
                'message' => 'Multi Image Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()
                ->route('all#multiImages')
                ->with($noti);
        }


    }// end method

    // delete multi image
    public function deleteMultiImages($id){
        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        $noti = [
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($noti);
    } // end method
}
