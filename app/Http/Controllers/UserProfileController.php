<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = auth::user();
        return view('user-profile' , compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
//            'email' => ['required' , 'string' , 'email' , 'max:255' , Rule::unique('users' , 'email')->ignore($user->id)],
            'profile_photo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=256,min_height=256|max:1000000',
        ]);


        $previousProfilePhoto = $user->profile_photo_path;
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $path = $image->store('profile-photos' , 'public');
            $request->merge([
                'profile_photo_path' => $path
                ]);
        }

        $user->update($request->except('email'));

        if($previousProfilePhoto &&$previousProfilePhoto != $user->profile_photo_path){
            Storage::disk('public')->delete($previousProfilePhoto);
//            unlink(public_path('storage/'.$previousProfilePhoto));
        }

        return redirect()->route('profile')
            ->with('success' , 'Profile Updated Successfully');
    }
}
