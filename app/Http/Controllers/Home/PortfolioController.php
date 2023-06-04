<?php

namespace App\Http\Controllers\Home;

use Image;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    // all portfolio page
    public function allPortfolio()
    {
        $portfolio = Portfolio::latest()->get();

        return view('admin.portfolio.all_portfolio', compact('portfolio'));
    } //end method

    // add portfolio page
    public function addPortfolio()
    {
        return view('admin.portfolio.add_portfolio');
    } // end method

    // store portfolio
    public function storePortfolio(Request $request)
    {
        $request->validate(
            [
                'portfolioName' => 'required',
                'portfolioTitle' => 'required',
            ],
            [
                'portfolioName.required' => 'Portfolio Name is Required',
                'portfolioTitle.required' => 'Portfolio Title is Required',
            ]
        );

        $image = $request->file('portfolioImage');
        $name_gen =
            hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 132345.jpg

        Image::make($image)
            ->resize(1020, 519)
            ->save('upload/portfolio_images/' . $name_gen); // resize with image

        $save_url = 'upload/portfolio_images/' . $name_gen; // create image path

        // store in database
        Portfolio::insert([
            'portfilo_name' => $request->portfolioName,
            'portfilo_title' => $request->portfolioTitle,
            'portfilo_image' => $save_url,
            'portfilo_description' => $request->portfolioDescription,
            'created_at' => Carbon::now(),
        ]);
        $noti = [
            'message' => 'Portfolio Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('all#portfolio')
            ->with($noti);
    } // end method

    // edit portfolio
    public function editPortfolio($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.edit_portfolio', compact('portfolio'));
    } // edit method

    // update portfolio
    public function updatePortfolio(Request $request)
    {
        $portfoli_id = $request->id;

        if ($request->file('portfolioImage')) {
            $image = $request->file('portfolioImage');
            $name_gen =
                hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 132345.jpg

            Image::make($image)
                ->resize(1020, 519)
                ->save('upload/portfolio_images/' . $name_gen); // resize with image

            $save_url = 'upload/portfolio_images/' . $name_gen; // create image path

            // store in database with image path
            Portfolio::findorFail($portfoli_id)->update([
                'portfilo_name' => $request->portfolioName,
                'portfilo_title' => $request->portfolioTitle,
                'portfilo_image' => $save_url,
                'portfilo_description' => $request->portfolioDescription,
            ]);
            $noti = [
                'message' => 'Portfolio Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()
                ->route('all#portfolio')
                ->with($noti);
        } else {
            // store in database without image path
            Portfolio::findorFail($portfoli_id)->update([
                'portfilo_name' => $request->portfolioName,
                'portfilo_title' => $request->portfolioTitle,
                'portfilo_description' => $request->portfolioDescription,
            ]);
            $noti = [
                'message' => 'Portfolio Updated without Image Successfully',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('all#portfolio')
                ->with($noti);
        } // end else
    } // end method

    // delete portfolio
    public function deletePortfolio($id){
        $portfolio = Portfolio::findOrFail($id);
        $image = $portfolio->portfilo_image;
        unlink($image);

        Portfolio::findOrFail($id)->delete();

        $noti = [
            'message' => 'Portfolio Data Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
        ->back()
        ->with($noti);

    }// end method

    // Detail portfolio page (frontend)
    public function detailPortfolio ($id){
        $portfolio = Portfolio::findOrFail($id);

        return view ('frontend.detail_portfolio',compact('portfolio'));
    }// end method

    // home portfolio page
    public function HomePortfolio(){
        $portfolio = Portfolio::latest()->get();
        return view('frontend.home_portfolio',compact('portfolio'));
    }

}
