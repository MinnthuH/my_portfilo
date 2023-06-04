<?php

namespace App\Http\Controllers\Home;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    // contact me page
    public function contactMe(){
        return view('frontend.contact');
    }// end method

    // store message
    public function storeMessage(Request $request){
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);
        $noti =[
            'message' => 'Your Message Submited Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($noti);
    }// end method

    // contact message backend
    public function contactMessage(){
        $contacts = Contact::latest()->get();
        return view('admin.contact.all_contact',compact('contacts'));
    }// end method

    // delete message backend
    public function DeleteMessage($id){
        Contact::findOrFail($id)->delete();

        $noti =[
            'message' => 'Your Message Delete Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($noti);
    }// end method
}
