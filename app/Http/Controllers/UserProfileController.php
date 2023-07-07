<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = auth::user();
        //from intl package
        $countries = Countries::getNames(App::getLocale());
        return view('user-profile' , compact('user' , 'countries'));
    }

    public function update(Request $request)
    {
        $user = auth::user();

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string' ,
            'birthday' => 'date|before:today',
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


        $request->merge([
            'name' => $request->first_name . ' ' . $request->last_name,
        ]);
        $user->update($request->except('email'));

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],                       //update
            $request->all()                            //create
        );


        if($previousProfilePhoto &&$previousProfilePhoto != $user->profile_photo_path){
            Storage::disk('public')->delete($previousProfilePhoto);
//            unlink(public_path('storage/'.$previousProfilePhoto));
        }

        return redirect()->route('profile')
            ->with('success' , 'Profile Updated Successfully');
    }
}
