<?php

namespace App\Http\Controllers\Home;

use App\Models\Footer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterController extends Controller
{
    // setup footer
    public function setupFooter(){
        $allfooter = Footer::find(1);
        return view('admin.footer.all_footer',compact('allfooter'));
    } //end method

    // update footer
    public function updateFooter(Request $request){
        $footerID = $request->id;

        Footer::findOrFail($footerID)->update([
            'number' => $request->number,
            'short_description' => $request->shortdescription,
            'address' => $request->address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'copyright' => $request->copyright,
        ]);
        $noti =[
            'message' => 'Footer Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($noti);
    } // end method
}
