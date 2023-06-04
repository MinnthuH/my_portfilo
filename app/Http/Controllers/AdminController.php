<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    // destory => logout
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $noti = [
            'message' => 'User Logout Successfully',
            'alert-type' => 'success',
        ];

        return redirect('/login')->with($noti);
    } //end method

    // admin profile
    public function profile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.adminProfileView', compact('adminData'));
    } // end method

    // edit profile page
    public function editProfile()
    {
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.adminProfileEdit', compact('editData'));
    } // end method

    // store admin update profile data
    public function storeProfile(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profileImage')) {
            $file = $request->file('profileImage');
            @unlink(public_path('upload/admin_images'));

            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['profile_image'] = $filename;
        }
        $data->save();
        $noti = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('admin.profile')
            ->with($noti);
    } // end method

    // change password page
    public function changePassword()
    {
        return view('admin.adminChangePassword');
    } // end method

    // update admin password
    public function updatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirmpassword' => 'required|same:newpassword',
        ]);
        $hasedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hasedPassword)){
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message','Password Updated Successfully');
            return redirect()->back();
        }else{
            session()->flash('message','Old password is not match');
            return redirect()->back();
        }

    } // end method
}
